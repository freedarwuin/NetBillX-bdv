<?php
/**
 * PHP Mikrotik Billing
 * Payment Gateway Banco de Venezuela - Pago Móvil
 * Autor: @tu_nombre
 */

function bdv_validate_config()
{
    global $config;
    if (empty($config['bdv_phone']) || empty($config['bdv_ci']) || empty($config['bdv_bank_code'])) {
        sendTelegram("Pasarela BDV no configurada");
        r2(U . 'order/package', 'w', "El administrador no ha configurado BDV Pago Móvil.");
    }
}

function bdv_show_config()
{
    global $ui;
    $ui->assign('_title', 'Banco de Venezuela - Pago Móvil');
    $ui->assign('banks', json_decode(file_get_contents('system/paymentgateway/bdv_banks.json'), true));
    $ui->display('bdv.tpl');
}

function bdv_save_config()
{
    global $admin;
    $bdv_phone = _post('bdv_phone');
    $bdv_ci = _post('bdv_ci');
    $bdv_bank_code = _post('bdv_bank_code');

    $settings = [
        'bdv_phone' => $bdv_phone,
        'bdv_ci' => $bdv_ci,
        'bdv_bank_code' => $bdv_bank_code
    ];

    foreach ($settings as $key => $value) {
        $d = ORM::for_table('tbl_appconfig')->where('setting', $key)->find_one();
        if ($d) {
            $d->value = $value;
            $d->save();
        } else {
            $d = ORM::for_table('tbl_appconfig')->create();
            $d->setting = $key;
            $d->value = $value;
            $d->save();
        }
    }
    _log('[' . $admin['username'] . ']: BDV ' . Lang::T('Settings_Saved_Successfully'), 'Admin', $admin['id']);
    r2(U . 'paymentgateway/bdv', 's', Lang::T('Settings_Saved_Successfully'));
}

function bdv_create_transaction($trx, $user)
{
    global $config;

    // Generar referencia única para el pago
    $reference = 'PM' . $trx['id'] . rand(100,999);

    $d = ORM::for_table('tbl_payment_gateway')
        ->where('username', $user['username'])
        ->where('status', 1)
        ->find_one();
    $d->gateway_trx_id = $reference;
    $d->pg_request = json_encode($trx);
    $d->expired_date = date('Y-m-d H:i:s', strtotime("+ 2 HOUR"));
    $d->save();

    // Mostrar instrucciones
    r2(U . "order/view/" . $trx['id'], 'i',
        "Realiza el pago móvil a:<br>
        Teléfono: <b>{$config['bdv_phone']}</b><br>
        Cédula/RIF: <b>{$config['bdv_ci']}</b><br>
        Banco: <b>{$config['bdv_bank_code']}</b><br>
        Monto: <b>{$trx['price']} VES</b><br>
        Referencia Única: <b>{$reference}</b>");
}

function bdv_get_status($trx, $user)
{
    // Aquí puedes integrar verificación automática con BDV si se habilita
    if ($trx['status'] == 2) {
        r2(U . "order/view/" . $trx['id'], 's', "Pago confirmado correctamente.");
    } else {
        r2(U . "order/view/" . $trx['id'], 'w', "En espera de pago. Ingresa la referencia al soporte.");
    }
}

function bdv_payment_notification()
{
    // Para futuras integraciones automáticas vía API o scraping BDV
    die('OK');
}