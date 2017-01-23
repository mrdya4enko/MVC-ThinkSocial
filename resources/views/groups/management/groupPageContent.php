<div class="w3-col m5 groups">
            <section class="group-header">
                <h2 class="group-name"> <?= $currentGroup->name; ?> </h2>
                <div class="group-desc"> <?= $currentGroup->description; ?></div>
            </section>

            <div class="post-news-panel">
                <div class="post-news-header">
                    <input class="post-news-input" type="text" placeholder="Add a new post to wall">
                </div>
                <div class="post-news-submit sg-hidden">
                    <label for="post-news-add-pic" class="post-news-photo"> Add picture to the news </label>
                    <input id="post-news-add-pic" type="file">
                    <textarea placeholder="Enter your article here" title="Article description" class="post-new-desc" ></textarea>
                    <button type="submit" class="w3-btn w3-ripple w3-blue post-new-submit"> Post </button>
                </div>
            </div>
</div>