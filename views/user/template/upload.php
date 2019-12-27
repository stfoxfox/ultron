<?php

/** @var $this \yii\web\View */
/** @var $model \app\models\User */

// верстальщик:
$this->registerJs("var config = {
      '.chosen-select' : {
            max_selected_options: 5,
            no_results_text: \"Ничего не найдено \",
          }
        }
        for (var selector in config) {
          $(selector).chosen(config[selector]);
        }
    
        $(function(){
            var priceVal;
            $('#free_template').change(function(){
                if($(this).is(':checked')){
                    $('#price_input, #price_input_new, #action_date_input').attr('disabled','disabled').addClass('disabled');
                }else{
                    $('#price_input, #price_input_new, #action_date_input').removeAttr('disabled').removeClass('disabled');
                }
            });
            
            // file upload
            $('#filer_input_archive').filer({
                limit: 1,
                maxSize: 150,
                extensions: [\"zip\", \"rar\"],
                showThumbs: true
            });            
        });")
?>

<div class="title-h2">Загрузить шаблон</div>
<div class="download-template-settings">
    <?= $this->render('_form', compact('model')) ?>
</div>