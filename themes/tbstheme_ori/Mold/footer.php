 <div id="footer" class="bottom">
    <div class="container">        
        <div class="sosmed2 col-md-12" style=" text-align: right; color: white; letter-spacing: 1px; border-top:2px dashed #999c4c; padding-top: 20px;">
            <div class="imgsosmed" style="padding-top: 5px;">
                <img onclick="window.open('<?= Efiwebsetting::getYoutubePage(); ?>', '_blank');" class="img-circle"
                     src="<?= _SPPATH; ?>images/youtube0.png" align="absmiddle"
                     onmouseover="this.src='<?= _SPPATH; ?>images/youtube1.png';"
                     onmouseout="this.src='<?= _SPPATH; ?>images/youtube0.png';"/>
                <img onclick="window.open('<?= Efiwebsetting::getFBPage(); ?>', '_blank');"  class="img-circle"
                     src="<?= _SPPATH; ?>images/fb0.png" align="absmiddle"
                     onmouseover="this.src='<?= _SPPATH; ?>images/fb1.png';"
                     onmouseout="this.src='<?= _SPPATH; ?>images/fb0.png';"/>
                <img  onclick="window.open('<?= Efiwebsetting::getTwitterPage(); ?>', '_blank');"  class="img-circle"
                     src="<?= _SPPATH; ?>images/twitter0.png" align="absmiddle"
                     onmouseover="this.src='<?= _SPPATH; ?>images/twitter1.png';"
                     onmouseout="this.src='<?= _SPPATH; ?>images/twitter0.png';"/>
            </div>
            <div class="alamat" style="margin-top:5px;">
                <a href="mailto:<?= Efiwebsetting::getEmail(); ?>"><?= Efiwebsetting::getEmail(); ?></a>
            </div>
            <div class="alamat" style="margin-top:5px;">
                <?= Efiwebsetting::getAddress(); ?>

            </div>

        </div>
    </div>
</div>