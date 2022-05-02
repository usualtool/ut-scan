# ut-scan
UT framework scanning vulnerability extension.

require_once dirname(__FILE__).'/'.'autoload.php';

use usualtool\Scan\Scan;

$scan=new Scan();

print_r($scan->Scan());
