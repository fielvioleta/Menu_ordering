<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Add Category</h4>
                    </div>
                    <div class="card-content">
                        <?php 
                        	echo $this->element('errors_section');
                        	echo $this->Form->create( 'Category' ,[
								'novalidate' => true,
								'enctype' => 'multipart/form-data'
							]);
                        ?>
	                            <div class="row">
	                                <div class="col-md-12">
										<div class="form-group label-floating">
											<?php 
												echo $this->Form->label( 'name' , 'Name',[
													'class' => 'control-label'
												]);
											?>
											<?php 
												echo $this->Form->input( 'name' , [
													'error'	=> false,
													'div' 	=> false,
													'label' => false,
													'class' => 'form-control'
												]);
											?>
										</div>
	                                </div>
	                            </div>

	                            <div class="row">
	                                <div class="col-md-12">
										<div class="form-group label-floating">
											<?php 
												echo $this->Form->label( 'description' , 'Description',[
													'class' => 'control-label'
												]);
											?>
											<?php 
												echo $this->Form->input( 'description' , [
													'error'	=> false,
													'div' 	=> false,
													'label' => false,
													'class' => 'form-control',
													'type'	=> 'textarea'
												]);
											?>
										</div>
	                                </div>
	                            </div>

	                            <div class="row">
	                                <div class="col-md-12">
										<div class="form-group">
											<?php 
												echo $this->Form->label( 'image' , 'Image',[
													'class' => 'control-label tx-font-size-14px'
												]);
											?>
											<?php 
												echo $this->Form->input('image', array(
													'type' => 'file',
													'label' => false,
													'id' => 'input2',
												));
											?>
											<div id="product_images"></div>
										</div>
	                                </div>
	                            </div>
	                            
								<button type="button" class="btn btn-primary pull-right" onClick="window.location.href='/admin/categories/list'">
									Cancel<div class="ripple-container"></div>
								</button>
						<?php 
							echo $this->Form->end([
								'label'	=> 'Save',
								'class'	=> 'btn btn-primary pull-right'
							]); 
						?>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		const files = <?php echo ( isset( $files ) ) ? json_encode($files) : "''" ?>;
		$('#input2').filer({
	        limit: 1,
	        extensions: ['jpg', 'jpeg', 'png', 'gif'],
	        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
	        showThumbs: true,
	        appendTo: '#product_images',
	        theme: "dragdropbox",
	        files: files,
	        templates: {
	            box: '<ul class="jFiler-item-list"></ul>',
	            item: '<li class="jFiler-item">\
	                        <div class="jFiler-item-container">\
	                            <div class="jFiler-item-inner">\
	                                <div class="jFiler-item-thumb">\
	                                    <div class="jFiler-item-status"></div>\
	                                    <div class="jFiler-item-info">\
	                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
	                                    </div>\
	                                    {{fi-image}}\
	                                </div>\
	                                <div class="jFiler-item-assets jFiler-row">\
	                                    <ul class="list-inline pull-left">\
	                                        <li>{{fi-progressBar}}</li>\
	                                    </ul>\
	                                    <ul class="list-inline pull-right">\
	                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
	                                    </ul>\
	                                </div>\
	                            </div>\
	                        </div>\
	                    </li>',
	            itemAppend: '<li class="jFiler-item">\
	                        <div class="jFiler-item-container">\
	                            <div class="jFiler-item-inner">\
	                                <div class="jFiler-item-thumb">\
	                                    <div class="jFiler-item-status"></div>\
	                                    <div class="jFiler-item-info">\
	                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
	                                    </div>\
	                                    {{fi-image}}\
	                                </div>\
	                                <div class="jFiler-item-assets jFiler-row">\
	                                    <ul class="list-inline pull-left">\
	                                    </ul>\
	                                    <ul class="list-inline pull-right">\
	                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
	                                    </ul>\
	                                </div>\
	                            </div>\
	                        </div>\
	                    </li>',
	            progressBar: '<div class="bar"></div>',
	            itemAppendToEnd: false,
	            removeConfirmation: false,
	            _selectors: {
	                list: '.jFiler-item-list',
	                item: '.jFiler-item',
	                progressBar: '.bar',
	                remove: '.jFiler-item-trash-action',
	            }
	        },
	        uploadFile: {
				success: function(data, el){
					var parent = el.find(".jFiler-jProgressBar").parent();
					el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
						$("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");    
					});
				},
			},
	        dragDrop: {
	            dragEnter: function(){},
	            dragLeave: function(){},
	            drop: function(){},
	        },
	        addMore: true,
	        clipBoardPaste: true,
	        excludeName: null,
	        beforeShow: function(){return true},
	        onSelect: function(){},
	        afterShow: function(){},
	        onRemove: function(){},
	        onEmpty: function(){},
	        captions: {
	            button: "Choose Files",
	            feedback: "Choose files To Upload",
	            feedback2: "files were chosen",
	            drop: "Drop file here to Upload",
	            removeConfirmation: "Are you sure you want to remove this file?",
	            errors: {
	                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
	                filesType: "Only Images are allowed to be uploaded.",
	                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
	                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
	            }
	        }
	    });
	});
</script>