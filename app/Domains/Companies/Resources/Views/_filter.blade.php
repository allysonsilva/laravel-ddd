<tr>
    {!! Form::open(['method' => 'GET']) !!}
        @filters

        <td>
            {!! Form::text('user_name_or_email', input('user_name_or_email'), ['autofocus', 'class' => 'form-control', 'placeholder' => 'Nome ou E-mail']) !!}
        </td>
        <td>
            {!! Form::text('cnpj', input('cnpj'), ['class' => 'form-control', 'placeholder' => 'CNPJ']) !!} </td>
        </td>
        <td>
            {!! Form::text('social_or_fantasy', input('social_or_fantasy'), ['class' => 'form-control', 'placeholder' => 'Razão ou Fantasia']) !!} </td>
        </td>

        <td></td>
        <td></td>

        <td class="text-center">
            {!! Form::button('<i class="fa fa-filter"></i>', ['type' => 'submit', 'class' => 'btn btn-space btn-secondary btn-lg']) !!}
        </td>
    {!! Form::close() !!}
</tr>
