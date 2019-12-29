Welcome : <?php echo e($user->name); ?>

Thank you for use this site, Please you should verifed you email from this link: 
<?php echo e(route('verifiy',$user->verification_token)); ?><?php /**PATH C:\xampp\htdocs\laravel\rest_api\resources\views/emails/welcome.blade.php ENDPATH**/ ?>