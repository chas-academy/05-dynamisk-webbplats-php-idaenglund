<div id="content">
    <?php if (isset($post)): ?>
        <form class="form1" method="POST" action="/post/<?php echo $post->getId()?>/update">
            <div class="writepost">
                <span class="text">Titel</span>
                <input type="text" name="title" style="width:700px;height:30px;" value="<?php echo $post->getTitle()?>">
                <span class="text">Blogtext</span>
                <textarea class="textarea" name="content" style="width:700px;height:400px;"><?php echo $post->getContent() ?></textarea>
                <button class="submit" type="submit" style="width:100px;height;100px;">Update</button>
            </div>
        </form>
    <?php endif; ?>
</div>