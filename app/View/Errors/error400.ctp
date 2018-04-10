<?php echo $this->html->css('error'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oops!</h1>
                <h2>
                    An error has occured</h2>
                <div class="error-details">
                    <?php echo $message; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
		<?php
		if (Configure::read('debug') > 0):
			echo $this->element('exception_stack_trace');
		endif;
		?>
    </div>
</div>
