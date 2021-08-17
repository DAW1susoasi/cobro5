<?php
$tamao_pagina = 25;
$total_paginas = ceil($num_filas / $tamao_pagina) ? ceil($num_filas / $tamao_pagina) : 1;
$anterior = $pagina - 1;
$siguiente = $pagina + 1;
$empezar_desde = ($pagina - 1) * $tamao_pagina;
?>