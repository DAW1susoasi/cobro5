<span><?php if($total_paginas > 2 && $pagina > 2) { ?><input type='button' class="paginacion" value='1'/><?php } else { ?> &nbsp;&nbsp;&nbsp; <?php } ?></span>
<span><?php if($pagina > 1) { ?><input type='button' class="paginacion" value='<?php echo $anterior; ?>'/><?php } else { ?> &nbsp;&nbsp;&nbsp; <?php } ?></span>
<span><?php if($pagina < $total_paginas) { ?><input type='button' class="paginacion" value='<?php echo $siguiente; ?>'/><?php } else { ?> &nbsp;&nbsp;&nbsp; <?php } ?></span>
<span><?php if($total_paginas > 1 && $pagina + 1 < $total_paginas) { ?><input type='button' class="paginacion" value='<?php echo $total_paginas; ?>'/><?php } else { ?> &nbsp;&nbsp;&nbsp; <?php } ?></span>