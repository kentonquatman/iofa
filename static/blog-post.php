<?php
  include 'partials/site-variables.php';
  $pageTitle = 'Blog | IOFA';
  $bodyId = 'blog';
  include 'partials/head.php';
  include 'partials/header.php';
?>

<section class="main">
  <div class="inner">
    <div class="posts">
      <article>
        <h1 class="post-title">Blog Post Title</h1>
        <p class="post-details">August 11, 2014</p>
        <p>In blandit hendrerit risus <strong>bold text</strong> sit amet luctus. Integer in libero est. Suspendisse pretium quis purus a porttitor. Sed ut dapibus turpis. Pellentesque lacinia nisi sit amet eros consequat, a fermentum nisi fringilla. Aenean dignissim nunc neque, nec molestie tortor placerat id. Sed non hendrerit magna. Vestibulum elementum quam at elit tristique, non sodales ipsum faucibus. Donec aliquam pulvinar lectus in egestas.</p>
        <h2>H2 Headline</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pellentesque tellus augue, nec auctor urna scelerisque vitae. Nulla iaculis nisi ut arcu blandit laoreet. Praesent vel vehicula dolor. Suspendisse ligula arcu, rutrum eu tellus non, mattis adipiscing dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam id diam interdum diam sagittis tempus a quis arcu. In eu placerat erat, in hendrerit lacus. Maecenas lacinia iaculis enim, eu convallis elit consectetur eget. In tempor fermentum turpis in malesuada. Quisque risus dui, pretium et turpis et, mattis sodales quam. Maecenas ut consequat dui.</p>
        <h3>H3 Headline</h3>
        <p>Proin id enim pretium, congue libero at, pretium leo. Nulla ac odio at mauris adipiscing cursus. Donec ut viverra augue. Nulla suscipit sapien vitae nibh auctor mattis. Curabitur a elit lorem. In cursus turpis non neque commodo, ut condimentum augue volutpat. Aenean in leo sed purus facilisis varius. Nam posuere magna sed viverra tempor. Etiam volutpat, lectus sit amet lacinia dapibus, nisl nisl rhoncus orci, eget sollicitudin ante dui sit amet turpis. Quisque blandit pulvinar mauris ut posuere. Ut vestibulum iaculis tincidunt. Phasellus in bibendum lectus.</p>
        <ul>
          <li>A list item</li>
          <li>Another list item</li>
          <li>A third list item</li>
        </ul>
        <p>Sed pretium a justo sed mattis. Mauris bibendum purus in magna congue fermentum. Ut ac ornare nisl. Proin commodo lorem eget nibh vehicula cursus hendrerit nec urna. Nunc erat eros, semper nec arcu vel, dapibus sodales enim. Aenean posuere at eros gravida sollicitudin. Donec tempor tellus et rhoncus condimentum. Aliquam erat volutpat. Aliquam vehicula vestibulum risus eu bibendum.</p>
        <p class="back"><a href="blog.php">Back to Blog</a></p>
      </article>
      <div class="pagination">
        <a href="javascript:void(0)" class="prev">Previous</a>
        <a href="javascript:void(0)" class="next">Next</a>
      </div>
    </div>
    <aside>
      <div class="monthly-archive">
        <h4>Archive</h4>
        <select>
          <option>- Select Month -</option>
          <option>Jaunuary 2014</option>
          <option>February 2014</option>
          <option>March 2014</option>
          <option>April 2014</option>
          <option>May 2014</option>
          <option>June 2014</option>
          <option>July 2014</option>
          <option>August 2014</option>
        </select>
        <ol>
          <li><a href="javascript:void(0)">Jaunuary 2014</a></li>
          <li><a href="javascript:void(0)">February 2014</a></li>
          <li><a href="javascript:void(0)">March 2014</a></li>
          <li><a href="javascript:void(0)">April 2014</a></li>
          <li><a href="javascript:void(0)">May 2014</a></li>
          <li><a href="javascript:void(0)">June 2014</a></li>
          <li><a href="javascript:void(0)">July 2014</a></li>
          <li><a href="javascript:void(0)">August 2014</a></li>
        </ol>
      </div>
      <div class="category-archive">
        <h4>Categories</h4>
        <select>
          <option>- Select Category -</option>
          <option>Category 1</option>
          <option>Category 2</option>
          <option>Category 3</option>
          <option>Category 4</option>
          <option>Category 5</option>
        </select>
        <ol>
          <li><a href="javascript:void(0)">Category 1</a></li>
          <li><a href="javascript:void(0)">Category 2</a></li>
          <li><a href="javascript:void(0)">Category 3</a></li>
          <li><a href="javascript:void(0)">Category 4</a></li>
          <li><a href="javascript:void(0)">Category 5</a></li>
        </ol>
      </div>
    </aside>
  </div>
</section>

<?php
  include 'partials/footer.php';
  include 'partials/foot.php';
?>