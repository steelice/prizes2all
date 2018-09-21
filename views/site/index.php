<?php

/* @var $this yii\web\View */

$this->title = 'ПСП - Получи Свой Приз!';
?>
<div class="site-index">

    <div class="roulette">
        <div class="promo">
            <h1>Призы всем!</h1>
            <p>Только сегодня! Только сейчас! Каждый зарегистрированный клиент может получить призы небывалой
                ценности!</p>
            <p>Вы можете получить:</p>
            <ul>
                <li>Денежный приз, который мы переведем вам на ваш банковский счет, либо вы получите его в виде
                    бонусов
                </li>
                <li>Реальный товар! Самые лучшие китайские безделушки, прямо из алиэкспресса!</li>
                <li>Бонусы в приложение! За них вы можете купить целую кучу ничего!</li>
            </ul>

            <?php
            if (Yii::$app->user->isGuest):
                ?>
                <p>Для получения приза вам необходимо зарегистрироваться!</p>
                <a class="btn btn-primary btn-lg btn-block" href="<?= \yii\helpers\Url::to(['user/register']) ?>">Регистрация</a>
                <br>
                <p>Если у вас уже есть аккаунт, то можно <a href="<?= \yii\helpers\Url::to(['user/login']) ?>">войти</a>
                </p>
            <?php
            else:
                ?>
                <button class="gamble btn btn-success btn-block" type="button">Получить приз</button>
            <?php
            endif;
            ?>
        </div>

        <div class="result hidden">
            <h1>Ваш выигрыш:</h1>
            <div class="title"></div>
            <div class="description"></div>

            <form class="userNotes specific-money hidden" method="post">
                <div>Сумма денег: <span class="label label-success value"></span></div>
                <div class="form-group">
                    <label>Укажите ваш банковский счет для зачисления денег</label>
                    <input type="text" class="form-control" name="userNotes">
                </div>
                <button class="btn btn-primary" type="submit">Отправить</button>
            </form>

            <div class="userNotes specific-bonus hidden">
                <div>Сумма бонусов: <span class="label label-success value"></span></div>
                Бонусы будут насчитаны на ваш счёт после проверки модератором!
            </div>

            <form class="userNotes specific-item hidden" method="post">
                Ваш подарок: <strong class="item-name"></strong>
                <div class="form-group">
                    <label>Укажите ваш адрес для отправки подарка</label>
                    <textarea type="text" class="form-control" name="userNotes" rows="2"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Отправить</button>
                <button class="btn btn-danger cancel" type="button">Отказаться от подарка</button>
            </form>
        </div>
    </div>

</div>
