<?php
namespace AjaxSystems;

$title = isset($title) ? $title : '';

$slides = [
    [
        'img'         => PLUGIN_URL.'/assets/img/slider-img-1.jpeg',
        'title'       => 'Flood-prevention system',
        'description' => 'Set the automatic water shut off in case the washing machine breaks or a pipe bursts. Control the water supply at the facility remotely or set up a schedule.',
        'link'        => [
            'url'  => '/',
            'text' => 'How to connect',
        ],
    ],
    [
        'img'         => PLUGIN_URL.'/assets/img/slider-img-2.jpeg',
        'title'       => 'Flood-prevention system',
        'description' => 'Set the automatic water shut off in case the washing machine breaks or a pipe bursts. Control the water supply at the facility remotely or set up a schedule.',
        'link'        => [
            'url'  => '/',
            'text' => 'How to connect',
        ],
    ],
    [
        'img'         => PLUGIN_URL.'/assets/img/slider-img-3.jpeg',
        'title'       => 'Flood-prevention system',
        'description' => 'Set the automatic water shut off in case the washing machine breaks or a pipe bursts. Control the water supply at the facility remotely or set up a schedule.',
        'link'        => [
            'url'    => '/',
            'text'   => 'How to connect',
            'target' => '_blank'
        ],
    ],
];
?>

<div class="slider section overflow-hidden">
    <?php
    DeferCSS::enqueue('swiper');
    DeferCSS::enqueue('slider');
    DeferJS::enqueue('slider');
    ?>
    <div class="wrapper">
        <div class="slider__inner">
            <?php if ($title) { ?>
                <h2 class="slider__title color-dark-3 ta-center"><?php echo $title; ?></h2>
            <?php } ?>
            <div class="swiper-container js-slider">
                <div class="swiper-wrapper">
                    <?php foreach ($slides as $index => $slide) {
                        if ($slide['img'] || $slide['title'] || $slide['description']) { ?>
                            <div class="swiper-slide">
                                <div class="slide">
                                    <?php if ($slide['img']) { ?>
                                        <div class="slide__img aload-bg"
                                             data-aload="<?php echo $slide['img']; ?>"></div>
                                    <?php } ?>
                                    <?php if ($slide['title']) { ?>
                                        <div class="slide__title h3"><?php echo $slide['title']; ?></div>
                                    <?php } ?>
                                    <?php if ($slide['description']) { ?>
                                        <div class="slide__description"><?php echo $slide['description']; ?></div>
                                    <?php } ?>
                                    <?php if (is_array($slide['link']) && array_key_exists('text',
                                            $slide['link']) && $slide['link']['text']) { ?>
                                        <div class="slide__link">
                                            <a class="btn-text"
                                               href="<?php echo $slide['link']['url']; ?>"
                                               target="<?php echo array_key_exists('target', $slide['link']) &&
                                               $slide['link']['target'] ? $slide['link']['target'] : '_self'; ?>"
                                            ><?php echo $slide['link']['text']; ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>
