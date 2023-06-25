<?php get_header(); ?>
<?php
$servername = "localhost";
$username = "sqluser";
$password = "password";
$dbname = "systemlike";

$conn = new mysqli($servername, $username, $password, $dbname);
?>
<div class="block1">
    <div class="block2forHeader">
        <p class="nameDescribesHeader">
            Header
        </p>
        <div class="block10">
            <div class="block101">
                <b><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Главная</a></b>
            </div>
            <div class="block102">
                <b><a href="<?php echo esc_url( home_url( '/category/articles/' ) ); ?>">Статьи</a></b>
            </div>
            <div class="block103">
                <b><a href="<?php echo esc_url( home_url( '/category/news/' ) ); ?>">Новости</a></b>
            </div>
        </div>
        <br>
    </div>

    <div class="block2">
        <div class="article">
            <p class="nameDescribesArticle">
                <?php single_cat_title(); ?>
            </p>
        </div>
        <br>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="block11">
            <div class="block111">
                <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'likediss' ) ); ?>
                </a>
                <?php endif; ?>
            </div>

            <div class="block113">
                <div class="block112">
                    <p class="nameOfArticle">
                        <b><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></b>
                    </p>
                </div>
                <div class="block1121">
                    <p class="nameDescribes1">
                        <?php the_excerpt(); ?>
                    </p>
                </div>
                <div class="block1122">
                    <p class="nameDescribes2">
                        Автор: <b><?php the_author(); ?></b>
                    </p>
                </div>
                
                <div class="block114like" id="likeShow">
                        <?php
                        $sqlFromTable = "SELECT likes FROM liked WHERE articleId=1 ORDER BY likes DESC";
                        $result1 = $conn->query($sqlFromTable);
                        $row = $result1->fetch_assoc();
                        $like = $row['likes'];
                        echo "<p class='nameDescribes1'><b>" . $like . "</b></p>";
                        ?>
                    </div>
                    <form id="likeSend" method="post" action="likedislike.php">
                        <?php
                        $sqlArticle = "SELECT id, articlename FROM article WHERE id = 1";
                        $result2 = $conn->query($sqlArticle);
                        $row = $result2->fetch_assoc();
                        $id = $row['id'];
                     //   echo $id;
                        ?>
                        <div class="block114" id="like" name="like">

                            <button class="noborder" type="submit" id="like" name="like">
                                <img align="right" class="likediss" src="img/plus.png" align="center">
                            </button>
                        </div>
                    </form>

                    <form id="dislikeSend" method="post" action="likedislike.php">
                        <div class="block115">
                            <button class="noborder" type="" id="dislike" name="dislike">
                                <img align="right" class="likediss" src="img/minus.png" align="center">
                            </button>
                        </div>
                    </form>
            </div>
        </div>
        <?php endwhile; endif; ?>
    </div>

    <div class="block22">
        <div class="article2">
            <p class="nameDescribesArticle">Sidebar</p>
        </div>
    </div>

    <div class="block2forFooter">
        <p class="nameDescribesHeader">
            Footer
        </p>
    </div>
</div>

<?php get_footer(); ?>
