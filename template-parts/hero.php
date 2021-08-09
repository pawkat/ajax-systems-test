<?php
namespace AjaxSystems;

$logos       = [
    [
        'name' => 'ajax',
        'url'  => PLUGIN_URL.'/assets/img/'.'ajax-logo-white.svg',
        'alt'  => 'Ajax Systems logo'
    ],
    [
        'name' => 'corpo',
        'url'  => PLUGIN_URL.'/assets/img/'.'corpo-vigili-giurati-logo.svg',
        'alt'  => 'Corpo Vigili Giurati Logo'
    ],
];
$title       = __('Save 10%', TEXT_DOMAIN);
$subtitle    = __('on a security system and services', TEXT_DOMAIN);
$description = __('<p>Become a Corpo Vigili Giuarati client to get an Ajax system starter kit with a 10% discount and pay 10% less for security services. It is a perfect combination of best-in-class equipment and professional alarm monitoring.</p>
<p>Moreover, by purchasing a security system, you can get a tax credit of 50% of the purchase.</p>', TEXT_DOMAIN);
$bg          = PLUGIN_URL.'/assets/img/hero-bg.jpeg';
?>

<div class="hero">
    <?php
    DeferCSS::enqueue('hero');
    DeferCSS::enqueue('logos');
    DeferCSS::enqueue('form');
    DeferJS::enqueue('order-form');
    ?>
    <div class="wrapper">
        <div class="hero__inner">
            <div class="hero__info">
                <?php if (count($logos)) { ?>
                    <div class="hero__logos">
                        <div class="logos">
                            <div class="logos__inner">
                                <?php foreach ($logos as $item) { ?>
                                    <div class="logos__item logos__item_<?php echo $item['name']; ?>">
                                        <img src="<?php echo $item['url']; ?>" alt="<?php echo $item['alt']; ?>"/>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <h1 class="hero__title">
                    <?php echo $title; ?>
                </h1>
                <h2 class="hero__subtitle">
                    <?php echo $subtitle; ?>
                </h2>
                <div class="hero__description">
                    <?php echo $description; ?>
                </div>
            </div>
            <div class="hero__img">
                <img src="<?php echo $bg; ?>" data-aload="<?php echo $bg; ?>" alt="" data-dont-load-immediately="true"/>
            </div>
            <div class="hero__form">
                <form class="form form_light js-order-form">
                    <div class="form__section">
                        <div class="form__title h3 ta-center">
                            <?php echo __('Order now', TEXT_DOMAIN); ?>
                        </div>
                        <p class="form__description caption ta-center">
                            <?php echo __('Leave your phone number and email for our experts to contact you shortly.',
                                TEXT_DOMAIN); ?>
                        </p>
                        <div class="form__field">
                            <input type="tel" placeholder="<?php echo __('Phone', TEXT_DOMAIN); ?>" id="phone"
                                   name="phone"/>
                        </div>
                        <div class="form__field">
                            <input type="email" placeholder="<?php echo __('Email', TEXT_DOMAIN); ?>" id="email"
                                   name="email"/>
                        </div>
                        <div class="form__field">
                            <input type="text" placeholder="<?php echo __('Name', TEXT_DOMAIN); ?>" id="name"
                                   name="name"/>
                        </div>
                    </div>
                    <div class="form__section form__section_p-mob-sm">
                        <input type="checkbox" id="terms" name="terms" required="required"/>
                        <label for="terms" class="caption-sm">
                            <?php echo __('I agree that Ajax Systems and its authorized partners can contact me via email or phone to purchase a security system. The information provided will not be used for other commercial purposes.',
                                TEXT_DOMAIN); ?>
                        </label>
                    </div>
                    <input type="submit" class="btn" value="<?php echo __('Order', TEXT_DOMAIN); ?>"/>
                </form>
            </div>
        </div>
    </div>
</div>
