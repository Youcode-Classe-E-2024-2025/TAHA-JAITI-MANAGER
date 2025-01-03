var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
import fetchData from "./fetch.js";
import showAlert from "./softAlert.js";
const container = document.getElementById("myAlbumsContainer");
const editForm = document.getElementById("editContainer");
const form = document.getElementById("editForm");
const fetchAlbums = () => __awaiter(void 0, void 0, void 0, function* () {
    try {
        const data = yield fetchData("./model/myalbums_fetch.php");
        if (container) {
            container.innerHTML = "";
            if (!data || data.length === 0) {
                container.innerHTML = '<p class="text-2xl">No existing albums.</p>';
                return;
            }
            data.forEach((album) => {
                const newDiv = document.createElement("div");
                newDiv.className =
                    "bg-gray-800 bg-opacity-50 backdrop-blur-lg rounded-lg shadow-xl overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1";
                newDiv.innerHTML = `
                    <img src="${album.cover_image}" alt="Album Cover" class="w-full h-[20rem] object-fit">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-primary-400 mb-2">${album.title}</h3>
                        <p class="text-gray-300 mb-4">${album.description}</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-400">Genres:  ${album.genres}</span>
                            <span class="text-lg font-bold text-primary-300">$${album.price}</span>
                        </div>
                        <div class="flex space-x-2">
                            <button id="editAlbum" class="btn_black w-full" aria-label="Edit Album">Edit</button>
                            <button id="deleteAlbum" class="btn_red w-full" aria-label="Delete Album">Delete</button>
                        </div>
                    </div>
                `;
                const deleteBtn = newDiv.querySelector("#deleteAlbum");
                const editBtn = newDiv.querySelector("#editAlbum");
                deleteBtn.addEventListener("click", () => {
                    deleteAlbum(album.id);
                });
                editBtn.addEventListener("click", () => {
                    openEdit(album);
                });
                container.appendChild(newDiv);
            });
        }
    }
    catch (error) {
        console.error("Error fetching albums:", error);
        showAlert("Failed to fetch albums. Please try again later.");
    }
});
const deleteAlbum = (id) => __awaiter(void 0, void 0, void 0, function* () {
    const response = yield fetch("./model/delete_album.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ album_id: id }),
    });
    const result = yield response.json();
    if (response.ok && result.success) {
        showAlert(result.message);
        fetchAlbums();
    }
    else {
        showAlert(result.error || "An error happened.");
    }
});
const openEdit = (album) => {
    const closeBtn = editForm.querySelector("#closeEdit");
    if (editForm && closeBtn) {
        editForm.classList.remove("hidden");
        closeBtn.addEventListener("click", () => {
            editForm.classList.add("hidden");
        });
        const inputs = form.querySelectorAll("input, textarea");
        inputs.forEach((input) => {
            if (input instanceof HTMLInputElement) {
                switch (input.name) {
                    case "editId":
                        input.value = String(album.id);
                        break;
                    case "editTitle":
                        input.value = album.title;
                        break;
                    case "editPrice":
                        input.value = album.price;
                        break;
                }
            }
            else if (input instanceof HTMLTextAreaElement) {
                input.value = album.description;
            }
        });
    }
};
const decimalRegex = /^\d+(\.\d+)?$/;
form.addEventListener('submit', (e) => __awaiter(void 0, void 0, void 0, function* () {
    e.preventDefault();
    const formData = new FormData(form);
    const price = formData.get('editPrice');
    const selectedGenres = formData.getAll('editGenres[]');
    let valid = true;
    if (!decimalRegex.test(price)) {
        showAlert('Please enter a valid number');
        valid = false;
        return;
    }
    if (selectedGenres.length > 3) {
        showAlert('Please select only 3 genres max.');
        valid = false;
        return;
    }
    if (valid) {
        try {
            yield editAlbum(formData);
        }
        catch (error) {
            showAlert('Failed to edit user. Please try again.');
        }
    }
}));
const editAlbum = (album) => __awaiter(void 0, void 0, void 0, function* () {
    const response = yield fetch('./model/edit_album.php', {
        method: 'POST',
        body: album,
    });
    const result = yield response.json();
    if (response.ok && result.status) {
        editForm.classList.add('hidden');
        showAlert(result.message);
        fetchAlbums();
    }
    else {
        editForm.classList.add('hidden');
        showAlert(result.message);
    }
});
fetchAlbums();
