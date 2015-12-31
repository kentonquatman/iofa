<?php
  $currentDonation = '$9,900';
  $goalDonation = '$15,000';
  $reformatCurrent = preg_replace("/[^0-9,.]/", "", $currentDonation);
  $reformatGoal = preg_replace("/[^0-9,.]/", "", $goalDonation);
  $progressMeter = ($reformatCurrent/$reformatGoal)*100;
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">

  <title>Donate to IOFA</title>

  <meta name="description" content="Help support the efforts of IOFA with a tax-deductible donation">
  <meta name="author" content="IOFA">
  <meta name="copyright" content="Copyright 2014">

  <meta name="DC.title" content="Donate to IOFA">
  <meta name="DC.subject" content="Help support the efforts of IOFA with a tax-deductible donation">
  <meta name="DC.creator" content="IOFA">

  <meta property="og:title" content="Donate to IOFA">
  <meta property="og:description" content="Help support the efforts of IOFA with a tax-deductible donation">
  <meta property="og:image" content="assets/img/facebook.png">
  <meta property="og:url" content="http://iofa.org/donations">

  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta http-equiv="cleartype" content="on">

  <link rel="stylesheet" type="text/css" href="assets/css/style.css">

  <script src="//use.edgefonts.net/sancreek;emilys-candy;alegreya.js"></script>

  <link rel="canonical" content="http://iofa.org/donations">

</head>
<body>
  <div class="progress-bar">
    <div class="inner">
      <p class="current"><?php echo $currentDonation; ?></p>
      <div class="bar">
        <div class="status" <?php echo 'style="width:'.$progressMeter.'%;"'; ?>>&nbsp;</div>
      </div>
      <p class="goal"><?php echo $goalDonation; ?></p>
    </div>
  </div>
  <div class="wrapper">
    <div class="main">
      <h1><a href="http://iofa.org/">IOFA</a></h1>
      <h2>It's Our Quinceañera!</h2>
      <div class="details">
        <p>Across the world, we celebrate young people's growth and maturity through rites of passage. But for vulnerable youth, such as those in foster care, orphans, or victims of abuse, the transition to adulthood is often marked by violence, poverty, and isolation. Without proper interventions, vulnerable youth may face lifelong economic and social hardships, as well as exposure to crime and exploitation. As IOFA commemorates fifteen years of working to improve the lives of young people around the world, please show your support with a generous contribution to our annual fund.</p>
      </div>
      <div class="donate">
        <h3>Donate today &amp; help us reach&nbsp;our&nbsp;goal</h3>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
          <input type="hidden" name="cmd" value="_s-xclick">
          <input type="hidden" name="hosted_button_id" value="FEP2YYEKVHKEN">
          <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
          <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
        <div class="sub">
          <p>The International Organization for Adolescents (IOFA) is a registered 501(c)(3) nonprofit organization. All donations to IOFA are tax deductible. Upon receiving your gift, IOFA will send you an acknowledgement that you may use for tax deduction purposes.</p>
          <p>Please contact us with any questions regarding donations by visiting our <a href="http://iofa.org/index.php?option=com_contact&view=contact&id=1&Itemid=106">Contact Page</a>.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
