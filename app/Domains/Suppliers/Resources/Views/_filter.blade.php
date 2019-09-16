<tr>
    {!! Form::open(['method' => 'GET']) !!}
        @filters

        <td>
            {!! Form::text('name', input('name'), ['autofocus', 'class' => 'form-control', 'placeholder' => 'Nome do Fornecedor']) !!}
        </td>
        <td>
            {!! Form::email('email', input('email'), ['class' => 'form-control', 'placeholder' => 'E-mail do Fornecedor']) !!} </td>
        </td>
        <td></td>
        <td align="center">
            {!! Form::select('status', map_status(), input('status'), ['class' => 'form-control w-75']) !!}
        </td>
        <td></td>

        <td class="text-center">
            {!! Form::button('<i class="fa fa-filter"></i>', ['type' => 'submit', 'class' => 'btn btn-space btn-secondary btn-lg']) !!}
        </td>
    {!! Form::close() !!}
</tr>
