<?php while ($row = mysqli_fetch_array($result2)) { ?>

    <a href="accept_post.php?id=<?php echo $row["id"] ?>" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true" id="center">
        <div class="d-flex gap-2 w-100 justify-content-between">
            <div>
                <h6 class="mb-0"><?php echo $row["title"] ?></h6>
                <span class="d-inline-block text-truncate" style="max-width: 150px;"><?php echo $row["discription"] ?></span>
            </div>
            <small class="opacity-50 text-nowrap"><?php echo $row["date"] ?></small>
        </div>
    </a>
<?php } ?>

    <nav aria-label="..." id="pagination">
        <ul class="pagination">
            <?php if ($page == 1) { ?>
                <li class="page-item disabled">
                    <a class="page-link"  tabindex="-1">Previous</a>
                </li>
            <?php } else { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page-1 ?>">Previous</a>
                </li>
            <?php } ?>

            <?php for($page = 1; $page<= $number_of_page; $page++) { ?>
                <li class="page-item"><a class="page-link" href = "?page=<?php echo $page ?>"><?php echo $page ?></a></li>
            <?php } ?>
            <?php if ($page == $number_of_page or $page > $number_of_page) { ?>
                <li class="page-item disabled">
                    <a class="page-link"  tabindex="-1">Next</a>
                </li>
            <?php } else { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page+1 ?>">Next <?php echo $page ?></a>
                </li>
            <?php } ?>

        </ul>
    </nav>
<?php
