<div id="content">
    <?php if (isset($post)): ?>
        <?php var_dump($post); ?>
        <form class="form1" method="POST" action="/post/<?php echo $post->getId()?>/update">
            <div class="writepost">
                <span class="text">Titel</span>
                <input type="text" name="title" style="width:700px;height:30px;" value="<?php echo $post->getTitle()?>">
                <span class="text">Blogtext</span>
                <textarea class="textarea" name="content" style="width:700px;height:400px;"><?php echo $post->getContent() ?></textarea>
                <select name="categorie_id">
                    <?php foreach ($categories as $category): ?>
                        <?php if ((int) $category['id'] !== $post->getCategorieId()): ?>
                            <option value="<?php echo $category['id'] ?>">
                                <?php echo $category['name'] ?>
                            </option>
                        <?php else: ?>
                            <option value="<?php echo $category['id'] ?>" selected="selected">
                                <?php echo $category['name']; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <select name="tags[]" multiple="multiple">
                    <?php $postTags = explode(',', $post->tag_ids) ?>
    
                    <?php foreach ($tags as $tag): ?>
                        <?php if (array_search($tag['id'], $postTags) === false): ?>
                            <option value="<?php echo $tag['id'] ?>">
                                <?php echo $tag['name'] ?>
                            </option>
                        <?php else: ?>
                            <option value="<?php echo $tag['id'] ?>" selected="selected">
                                <?php echo $tag['name']; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <button class="submit" type="submit" style="width:100px;height;100px;">Update</button>
            </div>
        </form>
    <?php endif; ?>
</div>