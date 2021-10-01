@if ($form == 'false')
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{ $modalSize }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                @if ($modalClose != 'false')
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @endif

                {{-- <button class="btn btn-primary btn-print">
                        Print
                    </button> --}}

                @if ($modalSubmit != 'false')
                <button type="submit" class="btn btn-primary" id="{{ $btnId }}">Simpan</button>
                @endif
            </div>
        </div>
    </div>
</div>

@else
<form id="{{ $formId }}" {!! $enctype=='true' ? 'enctype="multipart/form-data"' : '' !!}>
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog {{ $modalSize }}" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    @if ($modalClose != 'false')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @endif

                    @if ($modalSubmit != 'false')
                    <button type="submit" class="btn btn-primary" id="{{ $btnId }}">Simpan</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>
@endif
