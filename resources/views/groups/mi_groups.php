        <div class="w3-col m6 groups">
            <div class="panel">
                <div class="group-control">
                    <a href="/groups" class="w3-btn w3-ripple w3-orange small"> My Groups </a>
                    <a href="/groups/find" class="w3-btn w3-ripple w3-blue small"> Find Groups </a>
                    <a href="#" id="create-group-btn" class="w3-btn w3-white w3-border w3-border-blue w3-round make-group small"> Create Group </a>
                </div>
                <div class="search-wrapper">
                    <input title="Поиск групп" type="search" class="group-search" placeholder="Search in your groups">
                </div>
            </div>
            <?php foreach ($myGroups as $myGroup) : ?>
                <section class="group-card mine">
                <img src="<?= "/avatars/" . $myGroup->groupsAvatars[0]->fileName;?>" class="group-card__avatar" width="100px" height="100px">
                <div class="group-desc">
                    <a href="/groups/page/id<?= $myGroup->group->id;?>" class="group-card__group-name"> <?= $myGroup->group->name;?> </a>
                    <div class="group-card__desc"> <?= $myGroup->group->description;?> </div>
                </div>
                <a href="/groups/page/id<?= $myGroup->group->id;?>" class="group-card__subs w3-btn w3-ripple w3-teal"> To Page </a>
            </section>
            <?php endforeach; ?>

            <?php foreach ($Groups as $Group) : ?>
            <section class="group-card">
                <img src="<?= "/avatars/" .  $Group->groupsAvatars[0]->fileName;?>" class="group-card__avatar" width="100px" height="100px">
                <div class="group-desc">
                    <a href="/groups/page/id<?= $Group->group->id;?>" class="group-card__group-name"> <?= $Group->group->name;?> </a>
                     <div class="group-card__desc"> <?= $Group->group->description;?> </div>
                </div>
                <a href="/groups/unsubscribe/id<?= $Group->group->id?>" class="group-card__subs w3-btn w3-ripple w3-red"> Unsubscribe </a>
            </section>
            <?php endforeach; ?>
        </div>
<!--    </div>-->
<!--     End Page Container -->
    <div id="parange" class="parange">
        <div class="create-group">
            <h2 class="create-group__header"> Group Creation <span id="create-group-close" class="create-group__close"> Close </span> </h2>
            <form action="" method="post" class="form-bag">
                <label class="input-wrapp"><input type="text" name="group-name" class="group-create-input" placeholder="Enter Group Name Here" required></label>
                <textarea class="create-group__describe" placeholder="Short Decryption of Your Group"></textarea>
                <button type="submit" class="w3-btn w3-ripple w3-green create-group-btn"> Create </button>
            </form>
        </div>
    </div>
