<?php

### SIGMA

$route[] = ['/sigma/login', 'SigmaController', 'index'];

$route[] = ['/sigma/ws/pagina/{id}', 'SigmaController', 'ws'];

$route[] = ['/uni/ws/pagina/{id}', 'UniController', 'ws'];
