<?php
$text = "=?UTF-8?Q?Fwd:_=E1=80=99=E1=80=A1=E1=80=99=E1=80=AE=E1=80=90=E1=80=AC_?= =?UTF-8?Q?=E1=80=92=E1=80=AB=E1=80=80_=E1=80=95=E1=80=B6?= =?UTF-8?Q?=E1=80=AF=E1=80=86=E1=80=BC=E1=80=B2=E1=80=90=E1=80=B2?= =?UTF-8?Q?=E1=80=B7=E1=80=A1=E1=80=9C=E1=80=AF=E1=80=95=E1=80=B9?= =?UTF-8?Q?=E1=80=A1=E1=80=90=E1=80=BC=E1=80=80=E1=80=B9_?= =?UTF-8?Q?cover_letter?= =?UTF-8?Q?_=E1=80=94=E1=80=B2=E1=82=94_resume_.Application?= =?UTF-8?Q?_for_Electrical_Drafter.?=";



mb_internal_encoding('UTF-8');
$subject = "=?UTF-8?Q?=e2=99=a3?= Your winning day =?UTF-8?Q?=e2=99=a3?=";
echo mb_decode_mimeheader($subject);