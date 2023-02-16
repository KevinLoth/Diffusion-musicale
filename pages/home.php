<?php 
    require __DIR__."/../template/_header.php";
?>
<main>
    <section>
        <h2>    </h2>
        <div class="line">
            <?php 
                foreach($cards as $card){
                    echo "
                        <div class='card'>
                            <div class='card_img'>
                                <img src='$card->img' alt=''>
                            </div>
                            <div class='card_content'>
                                <h3>$card->title</h3>
                                <p>$card->artist</p>
                            </div>
                        </div>";
                }
            ?>
        </div>
    </section>

</main>


<?php 
    require __DIR__."/../template/_footer.php";
?>