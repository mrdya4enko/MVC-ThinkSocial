<!-- Middle Column -->
<style>
    em.comment {
        margin-left: 4em;
    }
</style>
<div class="w3-col m7">

    <div class="w3-row-padding">
        <div class="w3-col m12">
            <div class="w3-card-2 w3-round w3-white">
                <div class="w3-container w3-padding">
                    <a href="/friend/" id="allPeople" class="w3-btn w3-theme">My friends</a>
                </div>
                <div class="w3-container w3-padding">
                    <?php foreach ($people as $allPeople):/*Добавил проверку на НЕ пустой checkFriend*/
                        if(!empty($allPeople->checkFriend) && $allPeople->checkFriend === 'friend') {
                            $viewPeoples = 'Delete friend';
                            $hrefViewPeoples = '/friend/delete/' . $allPeople->id;
                        } else {
                            $viewPeoples = 'Add friend';
                            $hrefViewPeoples = '/friend/add/' . $allPeople->id;
                        }
                        ?>
                        <div class="w3-container w3-card-2 w3-white w3-round w3-margin">
                            <img src="/avatars/<?=$allPeople->avatarFileName?>">
                            <a href="#"><p><h3><?=$allPeople->firstName . ' ' . $allPeople->lastName;?></h3></p></a>
                            <a href="<?=$hrefViewPeoples?>" class="w3-btn w3-theme"><?=$viewPeoples?></a>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Middle Column -->
</div>
