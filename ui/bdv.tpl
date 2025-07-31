{include file="sections/header.tpl"}

<form class="form-horizontal" method="post" role="form" action="{$_url}paymentgateway/bdv">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-primary panel-hovered panel-stacked mb30">
                <div class="panel-heading">{Lang::T('Banco de Venezuela - Pago Móvil')}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Teléfono')}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="bdv_phone" name="bdv_phone"
                                value="{$_c['bdv_phone']}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Cédula / RIF')}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="bdv_ci" name="bdv_ci"
                                value="{$_c['bdv_ci']}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">{Lang::T('Banco')}</label>
                        <div class="col-md-6">
                            <select class="form-control" name="bdv_bank_code">
                                {foreach $banks as $bank}
                                    <option value="{$bank['code']}"
                                    {if $bank['code'] == $_c['bdv_bank_code']}selected{/if}
                                    >{$bank['name']}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-primary waves-effect waves-light"
                                type="submit">{Lang::T('Save Change')}</button>
                        </div>
                    </div>
                    <pre>/ip hotspot walled-garden
add dst-host=bdv.enlinea.com
add dst-host=*.bdv.enlinea.com</pre>
                    <small class="form-text text-muted">{Lang::T('Configura el bot de Telegram para recibir notificaciones de pago')}</small>
                </div>
            </div>
        </div>
    </div>
</form>

{include file="sections/footer.tpl"}