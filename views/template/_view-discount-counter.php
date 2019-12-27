<noindex>
<div class="action-timer-wrapper">
    <div class="row no-padding">
        <div class="col-sm-6">
            <div class="action-timer-text">
                <div class="table">
                    <div class="table-cell">
                        <div class="title">Экономьте <?= $model->getDiscountPercentage() ?>% на этом продукте</div>
                        <div class="text">Спешите! Предложение ограничено.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="action-timer">
                <div class="countdown" data-actionyear="<?= date('Y', strtotime($model->discount_date)) ?>"
                     data-actionmonth="<?= date('m', strtotime($model->discount_date)) ?>"
                     data-actionday="<?= date('d', strtotime($model->discount_date)) ?>">
                    <div class="countdown-text text-center">
                        <div class="row no-padding">
                            <div class="col-xs-3">
                                <span>дни</span>
                            </div>
                            <div class="col-xs-3">
                                <span>часы</span>
                            </div>
                            <div class="col-xs-3">
                                <span>минуты</span>
                            </div>
                            <div class="col-xs-3">
                                <span>секунды</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</noindex>