<div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
    <div class="list-group" id="list_item">
        <?php if (isset($_SESSION["username"])) { ?>
            <h1 class="h3 mb-4 fw-normal" id="sub_title">Add comment</h1>
            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true" id="add_comment">
                <form method="post" action="">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Comment" name="comment" id="comment"></textarea>
                        <label for="floatingTextarea">Comment</label>
                    </div>
                    <div class="form-floating mb-3">
                        <button type="submit" class="btn btn-primary">Save Form</button>
                        <button type="reset" class="btn btn-secondary">Reset Form</button>
                    </div>
                    <?php require_once "msg.php" ?>
                </form>
            </div>
        <?php } ?>
        <?php if ($status_comment) { ?>
            <?php foreach ($comments as $comment_dt) { ?>
                <div class="list-group-item list-group-item-action d-flex gap-3 py-3" id="add_comment"
                     aria-current="true">
                    <div class="d-flex gap-2 w-100 justify-content-between">
                        <div>
                            <span class="d-inline-block text-truncate multiline"
                                  style="max-width: 150px;"><?php echo $comment_dt[2] ?></span>
                        </div>
                        <small class="opacity-50 text-nowrap"><?php echo $comment_dt[3] ?></small>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

    </div>
    <div class="list-group" id="list_item">

    </div>
</div>