<div class="row pt-3">
    <div class="col-md-12">
        <div class="text-right mb-3 mt-3">
            @if ($hasSubmit)
                <button type="submit" class="btn btn-space btn-primary btn-lg">
                    <i class="icon icon-left mdi mdi-floppy"></i> Salvar
                </button>
            @endif
            <a href="{{ $routeBack }}" class="btn btn-space btn-secondary">
                <i class="icon icon-left fa fa-arrow-left"></i> {{ $textBack }}
            </a>
        </div>
    </div>
</div>
