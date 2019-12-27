<?php

use app\widgets\topmenu\TopMenu;
use app\widgets\slider\Slider;
use app\widgets\recently\Recently;
use app\widgets\news\News;
use app\widgets\subscribe\Subscribe;
use app\widgets\advantages\Advantages;
use app\widgets\social\Social;

/* @var $this yii\web\View */

//$this->title = 'My Yii Application';

?>

<?= Slider::widget() ?>
<?= TopMenu::widget() ?>

    <div class="push50"></div>
    
    
    

<?= Recently::widget() ?>
<?= Subscribe::widget() ?>
<?= Advantages::widget() ?>


<div class="hidden-xs hidden-sm">
<? //= Social::widget() ?>
</div>

<?= News::widget() ?>

<?php
/*
<div class="push10"></div>
<div class="index-content-bottom-section" style="background: #fff;">
    <div class="push50"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Что такое Lorem Ipsum?</h2>
                <div class="block-content">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec accumsan velit eget pellentesque sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In hac habitasse platea dictumst. Etiam a neque ligula. Vestibulum condimentum euismod interdum. Mauris fermentum tristique molestie. Mauris mauris purus, aliquam nec erat vel, venenatis hendrerit arcu. Sed scelerisque, enim sed elementum ornare, neque sapien facilisis nibh, ut egestas lorem augue nec turpis. Morbi suscipit mi at odio consequat semper. Nulla sollicitudin tincidunt velit at semper. Phasellus quis nulla vel turpis eleifend dignissim. Proin id justo a nibh rutrum malesuada quis in eros. Quisque cursus odio nibh, ac fermentum mauris feugiat eleifend. Aliquam cursus dignissim orci, ut iaculis velit aliquam non.
                    </p>
                    <p>
                        Integer vel tincidunt mi. Donec erat tellus, pellentesque a mattis in, viverra sit amet est. Proin lectus risus, tempor vel maximus vel, tempus in ante. Nunc in turpis vitae metus dictum tincidunt ut non orci. Proin aliquam ex nulla, ut rutrum ante molestie id. Nunc dignissim laoreet nulla, pharetra convallis lectus tristique quis. Maecenas eget sapien ac quam vulputate ultrices.
                    </p>
                </div>
                <div class="push30"></div>
            </div>
            <div class="col-md-6">
                <h2>Что такое Lorem Ipsum?</h2>
                <div class="block-content">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec accumsan velit eget pellentesque sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; In hac habitasse platea dictumst. Etiam a neque ligula. Vestibulum condimentum euismod interdum. Mauris fermentum tristique molestie. Mauris mauris purus, aliquam nec erat vel, venenatis hendrerit arcu. Sed scelerisque, enim sed elementum ornare, neque sapien facilisis nibh, ut egestas lorem augue nec turpis. Morbi suscipit mi at odio consequat semper. Nulla sollicitudin tincidunt velit at semper. Phasellus quis nulla vel turpis eleifend dignissim. Proin id justo a nibh rutrum malesuada quis in eros. Quisque cursus odio nibh, ac fermentum mauris feugiat eleifend. Aliquam cursus dignissim orci, ut iaculis velit aliquam non.
                    </p>
                    <p>
                        Integer vel tincidunt mi. Donec erat tellus, pellentesque a mattis in, viverra sit amet est. Proin lectus risus, tempor vel maximus vel, tempus in ante. Nunc in turpis vitae metus dictum tincidunt ut non orci. Proin aliquam ex nulla, ut rutrum ante molestie id. Nunc dignissim laoreet nulla, pharetra convallis lectus tristique quis. Maecenas eget sapien ac quam vulputate ultrices.
                    </p>
                </div>
                <div class="push30"></div>
            </div>
        </div>
    </div>
    <div class="push20"></div>
</div>
*/
?>
