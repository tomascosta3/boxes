<x-mail::message>
# Orden de reparación {{ $order->number }}

Estimado {{ $order->client->first_name }},<br>
A continuación te adjuntamos la información relacionada con la orden de reparación de su equipo.

Datos del cliente:
- Apellido: {{ $order->client->last_name }}
- Nombre: {{ $order->client->first_name }}
- Correo: {{ $order->client->email }}
- Teléfono: {{ $order->client->phone_number }}

Datos del equipo:
- Tipo: {{ $order->equipment->type->type }}
- Marca: {{ $order->equipment->brand->brand }}
- Modelo: {{ $order->equipment->model->model }}
- N/S: {{ $order->equipment->serial_number }}

Accesorios del equipo:<br>
{{ $order->accessories }}

Falla que presenta el equipo:<br>
{{ $order->failure }}

Ante cualquier consulta o duda no dude en comunicarse con los técnicos al número +542324545171 y referirse a la orden de reparación número #{{ $order->number }}.

Desde ya muchas gracias,<br>
Solido Connecting Solutions.
</x-mail::message>
