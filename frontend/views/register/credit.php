<?php

use yii\web\View;
use antkaz\vue\VueAsset;

VueAsset::register($this);
$this->title = 'В заявке отказано. Попробуйте подать заявку в другую компанию';
if(isset($otkazPage->title_seo) and !empty($otkazPage->title_seo)) { $this->title = $otkazPage->title_seo; }
if(isset($otkazPage->keywords) and !empty($otkazPage->keywords)) { $this->registerMetaTag(['name' => 'keywords','content' => $otkazPage->keywords]); }
if(isset($otkazPage->description) and !empty($otkazPage->description)) { $this->registerMetaTag(['name' => 'description','content' => $otkazPage->description]); }
$this->registerJsFile(Yii::getAlias('@web') . '/js_register/vue.min.js', ['position' => View::POS_END]);
$this->registerJsFile(Yii::getAlias('@web') . '/js_register/credit.js', ['position' => View::POS_END, 'type' => 'module']);
$this->registerJsVar('partners', $partners, $position = View::POS_BEGIN);
?>
<div id="credit">
    <section class="main-column" v-if="wMobile" style="display: none;" :style="{display: 'block'}">
        <h1 style="text-align: center;font-size: 20px;font-weight: bold;text-transform: uppercase;margin: 6px 16px 4px;"><?= $otkazPage->title ?></h1>
        <div class="text-content text-content-16">
            <p>&nbsp;</p>
            <div style="font-family: PTSans, sans-serif; text-align: justify;">
                <?= $otkazPage->text_top ?>
            </div>
            <div class="text-content__options-container mt-3 mb-4">
                <template
                    v-for="(partner, index) in partners"
                    v-bind:item="partner"
                    v-bind:index="index"
                >
                    <div v-bind:key="index" class="card border-2 rounded-lg position-relative card-margins card-paddings">
                        <img
                            :src="partner.image"
                            class="card-img-top"
                            style="padding-left: 1.25rem;width: 65%;max-width:230px;margin: 15px 0 0;">
                        <div class="card-body">
                            <div class="card-boby-content">
                                <div class="card-body-item d-flex align-content-between">
                                    <div class="card-body-item__label">Срок:</div>
                                    <div class="card-body-item__value">{{partner.srok}}</div>
                                </div>
                                <div class="card-body-item d-flex align-content-between">
                                    <div class="card-body-item__label">Ставка:</div>
                                    <div class="card-body-item__value">{{partner.stavka}}</div>
                                </div>
                                <div class="card-body-item d-flex align-content-between">
                                    <div class="card-body-item__label">ГЭСВ:</div>
                                    <div class="card-body-item__value">{{partner.gesv}}</div>
                                </div>
                                <div class="card-body-item d-flex align-content-between">
                                    <div class="card-body-item__label">Сумма:</div>
                                    <div class="card-body-item__value">{{partner.summa}}</div>
                                </div>
                            </div>
                            <a :href="partner.link"
                                role="button"
                                target="_blank"
                                style="font-weight:bold;font-size:16px;"
                                type="button"
                                class="btn btn-outline-orange btn-block btn-lg border-2 rounded-lg text-uppercase mt-4">Получить деньги</a>
                        </div>
                        <div
                            class="card-helmet rounded-top position-absolute"
                            :style="bestDeal(partner.best_deal)">
                            <span>{{partner.advantages}}</span>
                        </div>
                    </div>
                </template>
            </div>
            <div style="text-align: justify;">
                <?= $otkazPage->text_bottom ?>
            </div>
            <p>&nbsp;</p>
        </div>
    </section>
    <div class="width-wrapper" v-else>
        <section class="content">
            <div class="container">
                <div class="form__wrap" style="padding-left: 45px;padding-right:45px;">
                    <h2 style="text-align: center;"><?= $otkazPage->title ?></h2>
                    <p>&nbsp;</p>
                    <div style="font-family: PTSans, sans-serif; font-size: 20px;">
                        <?= $otkazPage->text_top ?>
                    </div>
                    <div class="text-content__options-container mt-3 mb-4">
                        <template
                            v-for="(partner, index) in partners"
                            v-bind:item="partner"
                            v-bind:index="index"
                        >
                            <div v-bind:key="index" class="card border-2 rounded-lg position-relative card-margins card-paddings">
                                <img
                                    :src="partner.image"
                                    class="card-img-top"
                                    style="padding-left: 1.25rem;max-width:230px;margin: 10px 0 0;height:100px;">
                                <div class="card-body" style="width: 250px;">
                                    <div class="card-boby-content">
                                        <div class="card-body-item d-flex align-content-between">
                                            <div class="card-body-item__label">Срок:</div>
                                            <div class="card-body-item__value">{{partner.srok}}</div>
                                        </div>
                                        <div class="card-body-item d-flex align-content-between">
                                            <div class="card-body-item__label">Ставка:</div>
                                            <div class="card-body-item__value">{{partner.stavka}}</div>
                                        </div>
                                        <div class="card-body-item d-flex align-content-between">
                                            <div class="card-body-item__label">ГЭСВ:</div>
                                            <div class="card-body-item__value">{{partner.gesv}}</div>
                                        </div>
                                        <div class="card-body-item d-flex align-content-between">
                                            <div class="card-body-item__label">Сумма:</div>
                                            <div class="card-body-item__value">{{partner.summa}}</div>
                                        </div>
                                    </div>
                                    <a :href="partner.link"
                                        role="button"
                                        target="_blank"
                                        style="font-weight:bold;font-size:16px;"
                                        type="button"
                                        class="btn btn-outline-orange btn-block btn-lg border-2 rounded-lg text-uppercase mt-4">Получить деньги</a>
                                </div>
                                <div
                                    class="card-helmet rounded-top position-absolute"
                                    :style="bestDeal(partner.best_deal)">
                                    <span>{{partner.advantages}}</span>
                                </div>
                            </div>
                        </template>
                    </div>
                    <p>&nbsp;</p>
                    <div style="font-family: PTSans, sans-serif; font-size: 20px;">
                        <?= $otkazPage->text_bottom ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>