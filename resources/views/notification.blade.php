@if(Session('status'))
<div role="alert" class="notification v-alert v-sheet v-sheet--tile theme--dark v-alert--border v-alert--border-left {{ Session('status') }}">
    <div class="v-alert__wrapper">
        @if(Session('icon'))
        <i aria-hidden="true" class="v-icon notranslate v-alert__icon mdi mdi-check-circle theme--dark">{{ Session('icon') }}</i>
        @endif
        <div class="v-alert__content">{{ Session('message') }}</div>
        <div class="v-alert__border v-alert__border--left"></div>
        <button type="button"
                class="v-alert__dismissible v-btn v-btn--flat v-btn--icon v-btn--round theme--dark v-size--small"
                aria-label="Close">
            <span class="v-btn__content">
                <i aria-hidden="true" class="v-icon notranslate mdi mdi-close-circle"></i>
            </span>
        </button>
    </div>
</div>
@endif