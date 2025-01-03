<header class="bg-gradient-to-b from-black to-transparent z-20 drop-shadow-xl text-white shadow-md absolute top-0 w-full">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center">
            <a href="index.php" class="text-2xl font-bold text-red-500 hover:text-red-400 transition-colors">
                MEZIKKA
            </a>
        </div>
        <ul class="flex space-x-4">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 3):  ?>
                <li><a
                        href="index.php?view=myalbums"
                        class="text-xl hover:text-red-500 transition-all">
                        MY ALBUMS
                    </a>
                </li>
            <?php endif; ?>
            <li><a
                    class="text-xl hover:text-red-500 transition-all"
                    href="index.php?view=library">LIBRARY</a>
            </li>
            <li><a
                    class="text-xl hover:text-red-500 transition-all"
                    href="index.php?view=about">ABOUT</a>
            </li>
        </ul>
        <nav class="flex justify-between">
            <ul class="flex items-center space-x-4">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>
                        <a class="btn_red mr-5 px-3" href="?view=purchase_history">
                            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                        </a>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== 3):  ?>
                            <a
                                href="index.php?view=upload_album"
                                class="btn_red mr-5 px-3">
                                <i class="fa-solid fa-upload text-lg"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 1):  ?>
                            <a
                                href="index.php?view=dashboard"
                                class="btn_red mr-5 px-3">
                                <i class="fa-brands fa-microsoft text-lg"></i>
                            </a>
                        <?php endif; ?>
                        <a
                            href="index.php?action=logout"
                            class="btn_black">
                            LOG OUT
                        </a>

                    </li>
                <?php else: ?>
                    <li>
                        <a
                            href="index.php?view=register"
                            class="btn_red">
                            SIGN UP
                        </a>
                    </li>
                    <li>
                        <a
                            href="index.php?view=login"
                            class="btn_black">
                            LOG IN
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>