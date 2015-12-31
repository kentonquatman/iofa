<?php
  include 'partials/site-variables.php';
  $pageTitle = 'Site Name';
  $bodyId = 'home';
  include 'partials/head.php';
  include 'partials/header.php';
?>

<section class="slideshow loading">
  <ul class="slides">
    <li>
      <img src="assets/img/slides/slide-photo-01.jpg">
      <article class="summary">
        <a href="#">
          <h3>Slide Title One</h3>
          <p>Short description about the featured content. This can be for a new project, fundraising campaign, special blog post.</p>
        </a>
      </article>
    </li>
    <li>
      <img src="assets/img/slides/slide-photo-02.jpg">
      <article class="summary">
        <a href="#">
          <h3>Slide Title Two</h3>
          <p>Short description about the featured content. This can be for a new project, fundraising campaign, special blog post.</p>
        </a>
      </article>
    </li>
    <li>
      <img src="assets/img/slides/slide-photo-03.jpg">
      <article class="summary">
        <a href="#">
          <h3>Slide Title Three</h3>
          <p>Short description about the featured content. This can be for a new project, fundraising campaign, special blog post.</p>
        </a>
      </article>
    </li>
  </ul>
</section>

<section class="main">
  <article>
    <h1>Our Mission</h1>
    <p>Etiam sagittis nibh non enim cursus bibendum. Quisque eget nunc quis diam ultrices consectetur. Cras tempus velit lacinia odio vulputate porttitor. Vestibulum aliquet cursus odio eget suscipit. Proin dui massa, vestibulum non lectus a, placerat egestas lectus. Sed a turpis hendrerit, egestas lectus vitae, hendrerit massa. Sed commodo, ligula vitae tempor tempus, justo libero mattis urna, non convallis ante sem quis velit. Fusce est eros, tempus et pellentesque sit amet, cursus eu dui. Sed at luctus ipsum, id venenatis ipsum.</p>
  </article>
</section>

<section class="blog">
  <div class="inner">
    <h3 class="title">Recent Blog Posts</h3>
    <div class="posts">
      <article>
        <h3 class="post-title"><a href="blog-post.php">Blog Post Title</a></h3>
        <p class="post-details"><time>August 8, 2014</time></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget sapien commodo, mollis lorem vel, fermentum massa. Nunc porta quis massa ut iaculis. Mauris tristique enim tortor, blandit viverra augue commodo in. Duis non justo facilisis, semper risus eget, lobortis tellus. Mauris vestibulum dui ut posuere venenatis. Aliquam in sem vitae risus mollis consectetur.</p>
        <p class="more"><a href="blog-post.php">Keep Reading</a></p>
      </article>
      <article>
        <h3 class="post-title"><a href="blog-post.php">Blog Post Title</a></h3>
        <p class="post-details"><time>August 8, 2014</time></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget sapien commodo, mollis lorem vel, fermentum massa. Nunc porta quis massa ut iaculis. Mauris tristique enim tortor, blandit viverra augue commodo in. Duis non justo facilisis, semper risus eget, lobortis tellus. Mauris vestibulum dui ut posuere venenatis. Aliquam in sem vitae risus mollis consectetur.</p>
        <p class="more"><a href="blog-post.php">Keep Reading</a></p>
      </article>
      <article>
        <h3 class="post-title"><a href="blog-post.php">Blog Post Title</a></h3>
        <p class="post-details"><time>August 8, 2014</time></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget sapien commodo, mollis lorem vel, fermentum massa. Nunc porta quis massa ut iaculis. Mauris tristique enim tortor, blandit viverra augue commodo in. Duis non justo facilisis, semper risus eget, lobortis tellus. Mauris vestibulum dui ut posuere venenatis. Aliquam in sem vitae risus mollis consectetur.</p>
        <p class="more"><a href="blog-post.php">Keep Reading</a></p>
      </article>
      <article>
        <h3 class="post-title"><a href="blog-post.php">Blog Post Title</a></h3>
        <p class="post-details"><time>August 8, 2014</time></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget sapien commodo, mollis lorem vel, fermentum massa. Nunc porta quis massa ut iaculis. Mauris tristique enim tortor, blandit viverra augue commodo in. Duis non justo facilisis, semper risus eget, lobortis tellus. Mauris vestibulum dui ut posuere venenatis. Aliquam in sem vitae risus mollis consectetur.</p>
        <p class="more"><a href="blog-post.php">Keep Reading</a></p>
      </article>
    </div>
    <a href="blog.php" class="button">See More</a>
  </div>
</section>

<?php
  include 'partials/footer.php';
  include 'partials/foot.php';
?>