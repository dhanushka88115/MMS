<?php if (strlen($_SESSION['login']) !== 0) { ?>
    <h2 style="color: maroon; display: inline-block;">PassHat - Mail Action Monitoring System</h2>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <h3 style="color: green; display: inline-block;">[USER:<?php echo strtoupper($_SESSION['fname']) ?>]</h3>
<?php } else { ?>
    <h2 style="color: maroon;">PassHat - Mail Action Monitoring System</h2>
<?php } ?>
