# Pasarela de Pago Banco de Venezuela (Pago Móvil) para NetBillX

Integración de BDV Pago Móvil como método de pago en PHPNuxBill/Mikrotik Hotspot.

## Características
- Configuración de teléfono, cédula y banco BDV.
- Generación de referencia única para cada transacción.
- Compatible con todos los bancos venezolanos vía Pago Móvil.
- Modo manual o adaptable a verificación automática.

## Instalación
1. Copia **bdv.php** y **bdv.tpl** en `ui`
2. Copia **bdv_banks.json** en `system/paymentgateway/`
3. Activa la pasarela desde el panel de administración.

## Autor
Freedarwuin