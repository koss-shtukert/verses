<?php
/**
 * Created by LIS.
 * User: Koss (karakurtkoss{at}gmail.com)
 * Date: 08.09.2014
 */
?>
<h1>Мой профиль</h1>

<hr/>

{{ Form::model($user, ['route' => ['profile', $user->getNicknameOrId()], 'POST', 'autocomplete' => 'off', 'class' => 'profile']) }}
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            {{ Form::label('email', 'Email') }}
            {{ Form::email('email', null, ['class' => 'form-control input-lg', 'readonly']) }}
            {{ $errors->first('email', '<p class="help-block help-block-error">:message</span>') }}
        </div>
        <div class="form-group">
            {{ Form::label('first_name', 'Имя') }}
            {{ Form::text('first_name', null, ['class' => 'form-control input-lg', 'required']) }}
            {{ $errors->first('first_name', '<p class="help-block help-block-error">:message</span>') }}
        </div>
        <div class="form-group">
            {{ Form::label('last_name', 'Фамилия') }}
            {{ Form::text('last_name', null, ['class' => 'form-control input-lg', 'required']) }}
            {{ $errors->first('last_name', '<p class="help-block help-block-error">:message</span>') }}
        </div>
        <div class="form-group">
            {{ Form::label('nick_name', 'Сценическое имя (nickname)') }}
            {{ Form::text('nick_name', null, ['class' => 'form-control input-lg', 'required']) }}
            {{ $errors->first('nick_name', '<p class="help-block help-block-error">:message</span>') }}
        </div>
        <div class="form-group">
            {{ Form::label('birthday', 'Дата рождения') }}
            {{ Form::text('birthday', null, ['class' => 'form-control input-lg', 'required']) }}
            {{ $errors->first('birthday', '<p class="help-block help-block-error">:message</span>') }}
        </div>
        <div class="form-group">
            {{ Form::label('gender', 'Пол', ['class' => 'mb0']) }}

            <div class="radio">
                <label>
                    {{ Form::radio('gender', 'male', null, ['required']) }}
                    <span>M</span>
                </label>
            </div>

            <div class="radio">
                <label>
                    {{ Form::radio('gender', 'female', null, ['required']) }}
                     <span>Ж</span>
                </label>
            </div>
        </div>

        <div class="change-password-block" style="display:none;">
            <div class="form-group">
                {{ Form::label('password', 'Пароль') }}
                {{ Form::password('password', ['class' => 'form-control input-lg']) }}
                {{ $errors->first('password', '<p class="help-block help-block-error">:message</span>') }}
            </div>

            <div class="form-group">
                {{ Form::label('password_confirmation', 'Повторите пароль') }}
                {{ Form::password('password_confirmation', ['class' => 'form-control input-lg']) }}
            </div>
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="form-group">
            {{ Form::label('about', 'О себе') }}
            {{ Form::textarea('about', null, ['class' => 'form-control input-lg', 'rows' => 17]) }}
            {{ $errors->first('about', '<p class="help-block help-block-error">:message</span>') }}
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">
            {{ Form::submit('Сохранить', ['class' => 'btn btn-inline']) }}
            {{ Form::button('Отмена', ['class' => 'btn btn-inline btn-not-change-password', 'style' => 'display:none;']) }}
            {{ Form::button('Изменить пароль', ['class' => 'btn btn-inline btn-change-password']) }}
        </div>
    </div>
{{ Form::close() }}