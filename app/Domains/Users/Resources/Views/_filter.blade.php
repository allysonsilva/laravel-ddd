@inject('roleRepository', 'App\Domains\Users\Repositories\RoleRepository')

<tr>
    {!! Form::open(['method' => 'GET']) !!}
        @filters

        <th></th>
        <td> {!! Form::text('name_or_email', input('name_or_email'), ['class' => 'form-control', 'placeholder' => 'Nome ou E-mail']) !!} </td>
        <td align="center">
            {!! Form::select('role', ($roleRepository->mapRoles())->prepend('Selecione', ''), input('role'), ['class' => 'form-control w-75']) !!}
        </td>
        <td align="center">
            {!! Form::select('status', map_status(), input('status'), ['class' => 'form-control w-75']) !!}
        </td>
        <td></td>
        <td></td>

        <td class="text-center">
            {!! Form::button('<i class="fa fa-filter"></i> Filtar', ['type' => 'submit', 'class' => 'btn btn-space btn-secondary btn-lg']) !!}
        </td>
    {!! Form::close() !!}
</tr>
