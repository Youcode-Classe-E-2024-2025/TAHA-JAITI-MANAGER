<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?view=register");
    exit();
}

include './includes/db.php';

$albumsPerPage = 8;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $albumsPerPage;

$query = "  SELECT 
                a.id, 
                a.title, 
                a.description, 
                a.price, 
                a.cover_image, 
                STRING_AGG(DISTINCT g.name, ', ') AS genre_names
            FROM 
                Albums a
            LEFT JOIN 
                album_genres ag ON a.id = ag.album_id
            LEFT JOIN 
                Genres g ON ag.genre_id = g.id
            WHERE 
                a.is_archived = false
            GROUP BY 
                a.id
            ORDER BY 
                a.created_at DESC
            LIMIT :limit OFFSET :offset;";

$stmt = $pdo->prepare($query);
$stmt->execute([
    ":limit" => $albumsPerPage,
    ":offset" => $offset
]);

$albums = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $albums[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'description' => $row['description'],
        'price' => $row['price'],
        'cover_image' => $row['cover_image'],
        'genres' => $row['genre_names']
    ];
}

$countQuery = "SELECT COUNT(*) FROM Albums WHERE is_archived = false";
$countStmt = $pdo->query($countQuery);
$totalAlbums = $countStmt->fetchColumn();
$totalPages = ceil($totalAlbums / $albumsPerPage);

?>


<main class="container mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold text-primary-400 mb-8">Library</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- ALBUMS -->
        <?php if (empty($albums)): ?>
            <h2 class="text-2xl">No albums in the library.</h2>
        <?php else: ?>
            <?php foreach ($albums as $album): ?>
                <div class="bg-gray-800 bg-opacity-50 backdrop-blur-lg rounded-lg shadow-xl overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1">
                    <img src="<?php echo $album['cover_image'] ?: 'https://via.placeholder.com/400x400'; ?>" alt="Album Cover" class="w-full h-[20rem] object-fit">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-primary-400 mb-2"><?php echo htmlspecialchars($album['title']); ?></h3>
                        <p class="text-gray-300 mb-4"><?php echo htmlspecialchars($album['description']); ?></p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-400">Genres: <?php echo $album['genres']; ?></span>
                            <span class="text-lg font-bold text-primary-300">$<?php echo number_format($album['price'], 2); ?></span>
                        </div>
                        <input type="hidden" id="albumId" value="<?php echo $album['id']; ?>">
                        <button class="buyBtn btn_red w-full">PURCHASE</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Pop-up -->
    <div id="purchasePopup" class="popUp hidden">
        <div  class="bg-gray-800 bg-opacity-70 backdrop-blur-md rounded-xl shadow-2xl p-8 max-w-md w-full scale-95">
            <h2 class="text-2xl font-bold text-primary-400 mb-4">Confirm Purchase</h2>
            <p class="text-gray-300 mb-6">Are you sure you want to buy this album?</p>
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-xl font-semibold text-primary-300">Neon Dreams</h3>
                    <p class="text-gray-400">by Electro Harmony</p>
                </div>
                <span class="text-2xl font-bold text-primary-400">$9.99</span>
            </div>
            <div class="flex space-x-4">
                <button id="confirmPurchase" class="btn_red flex-1">
                    Confirm
                </button>
                <button id="cancelPurchase" class="btn_black flex-1">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-8">
        <div class="flex space-x-4">
            <!-- Previous Button -->
            <?php if ($page > 1): ?>
                <a href="?view=library&page=<?php echo $page - 1; ?>" class="btn_black">Previous</a>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?view=library&page=<?php echo $i; ?>" class="btn_black <?php echo $i == $page ? 'bg-red-600' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <!-- Next Button -->
            <?php if ($page < $totalPages): ?>
                <a href="?view=library&page=<?php echo $page + 1; ?>" class="btn_black">Next</a>
            <?php endif; ?>
        </div>
    </div>
</main>

<script type="module" src="./dist/buy_album.js"></script>