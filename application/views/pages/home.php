<h2><?= $title ?></h2>
<?php if ($this->session->flashdata('email_recov_sent')) { ?>
    <span class="text-success"><?= $this->session->flashdata('email_recov_sent') ?></span>
 <?php } ?>
<p>Wlcome to friendmii</p>