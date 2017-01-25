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
                            <a href="/friend/all" id="allPeople" class="w3-btn w3-theme">All people</a>
                        </div>
                        <div class="w3-container w3-padding">
                            <?php
                            if(!empty($myFriend)){
                                foreach($myFriend as $allFriend):?>
                            <div class="w3-container w3-card-2 w3-white w3-round w3-margin">
                                <img src="/avatars/<?=$allFriend->avatarFileName?>">
                                <a href="#"><p><h3><?=$allFriend->firstName . ' ' . $allFriend->lastName;?></h3></p></a>
                                <a href="/friend/delete/<?=$allFriend->id?>" class="w3-btn w3-theme">Delete friend</a>
                            </div>
                            <?php endforeach;
                            } else {
                                echo 'No friends';
                            }?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Middle Column -->
        </div>
