<?php
  include 'partials/site-variables.php';
  $pageTitle = 'Contact Us | IOFA';
  $bodyId = 'contact';
  include 'partials/head.php';
  include 'partials/header.php';
?>

<section class="main">
  <div class="inner">
    <header>
      <h1>Contact Us</h1>
    </header>
    <form class="contact-form">
      <h4><label for="name">Your Full Name</label></h4>
      <input type="text" id="name">
      <h4><label for="email">Your E-Mail Address</label></h4>
      <input type="text" id="email">
      <h4><label for="department">Select a Department</label></h4>
      <select id="department">
        <option>General Inquiry</option>
        <option>Donations</option>
        <option>Another Department</option>
        <option>And Another Department</option>
      </select>
      <h4><label for="message">Message</label></h4>
      <textarea></textarea>
      <input type="submit" value="Send">
    </form>
    <aside>
      <h4>Contact Information</h4>
      <address>
        <strong>Mailing Address:</strong><br>
        1234 Street St.<br>
        City, State 12345
      </address>
      <p><strong>P:</strong> 123-456-7890</p>
      <p><strong>F:</strong> 123-456-7890</p>
    </aside>
  </div>
</section>

<?php
  include 'partials/footer.php';
  include 'partials/foot.php';
?>