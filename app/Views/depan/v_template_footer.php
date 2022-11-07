</div>
</div>
</div>
<!-- Footer-->
<footer class="border-top">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <?php
                helper('global_fungsi_helper');

                $konfigurasi_name = 'set_socials_twitter';
                $dataSocials = konfigurasi_get($konfigurasi_name);
                $twitter = $dataSocials['konfigurasi_value'];

                $konfigurasi_name = 'set_socials_facebook';
                $dataSocials = konfigurasi_get($konfigurasi_name);
                $facebook = $dataSocials['konfigurasi_value'];

                $konfigurasi_name = 'set_socials_github';
                $dataSocials = konfigurasi_get($konfigurasi_name);
                $github = $dataSocials['konfigurasi_value'];

                ?>
                <ul class="list-inline text-center">
                    <?php if ($twitter) { ?>
                        <a href="<?php echo $twitter ?>" target="blank">
                            <li class="list-inline-item">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                        </li>
                    <?php } ?>
                    <?php if ($facebook) { ?>
                        <li class="list-inline-item">
                            <a href="<?= $facebook ?>" target="blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($github) { ?>
                        <li class="list-inline-item">
                            <a href="<?= $github ?>" target="blank">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <div class="small text-center text-muted fst-italic">Copyright &copy; Mursidi ON <?php echo date('Y') ?> </div>
            </div>
        </div>
    </div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="<?= base_url('depan') ?>/js/scripts.js"></script>
</body>

</html>