
        
        <!-- Show Error -->
            <?php 

            if(isset($_SESSION['errors'])): ?>
            <div class="alert alert-warning" role="alert">
                <ul>
                    <?php foreach($_SESSION['errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); endif; ?>

            <!-- added to db -->
            <?php if(isset($_SESSION['Done'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['Done']; ?>
            </div>
            <?php unset($_SESSION['Done']); ?>
            <?php endif; ?>


