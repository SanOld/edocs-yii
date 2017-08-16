<?php
$allowedMimes =  array(
    'application/pdf', 
    'application/zip', // docx
    'application/vnd.ms-office', // doc созданный с помощью OpenOffice 
    'application/msword'
);

$allowedExtentions = array('pdf', 'docx', 'doc');

$pdfInfoPath = '/usr/bin/pdfinfo'; // полный путь к pdfinfo
$pdfToTextPath = '/usr/bin/pdftotext'; // полный путь к pdftotext
$catDocPath = '/usr/bin/catdoc'; // полный путь к catdoc

// загружаем библиотеку Zеnd-а для считывания файлов формата docx
define('FILE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
if (strpos(get_include_path(), 'Zend.phar.gz') === false) {
  $r = ini_get('include_path') . ':phar\://' . FILE_PATH . 'Zend.phar.gz';
    ini_set('include_path', ini_get('include_path') . ':phar\://' . FILE_PATH . 'Zend.phar.gz');
}
$phar = new Phar(FILE_PATH . 'Zend.phar.gz', 0, 'Zend.phar.gz');
if (isset($phar['Zend/Search/Lucene/Document/Docx.php'])) {
    require_once($phar['Zend/Search/Lucene/Document/Docx.php']);
} else {
    echo 'ERROR: can\'t load "Zend/Search/Lucene/Document/Docx.php" !' . PHP_EOL;
    die;
}

// Начинаем формирование XML
$xmlWriter = new xmlWriter();
$xmlWriter->openMemory();
$xmlWriter->setIndent(true);
$xmlWriter->startDocument('1.0', 'UTF-8');

$xmlWriter->startElement('sphinx:docset');

$xmlWriter->startElement('sphinx:schema');
$xmlWriter->startElement('sphinx:field');
$xmlWriter->writeAttribute('name', 'content');
$xmlWriter->endElement(); // field
$xmlWriter->endElement(); // schema

/*
 Предположим что файлы лежат в папке files, 
 в которой находятся другие папки с названиями, 
 которые соответсвуют id пользователя.
 Например: files/01/file.pdf
*/
// Запускаем цикл по папке files
foreach (new DirectoryIterator('E:\Work\Servers\OpenServer524\domains\edocs-yii\web\docs') as $folder) {
    // Проверяем, является ли выбраные обьект папкой
    if (!$folder->isDir() || $folder->isDot()) {
        continue;
    }
    // Запускаем цикл по папке в которой теоретически должны находится файлы
    foreach (new DirectoryIterator($folder->getPathname()) as $file) {
        // Проверяем выбранный объект является ли файлом разрешенного типа 
        if ($file->isDir() || !in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $allowedExtentions) 
            || !in_array(mime_content_type($file->getPathname()), $allowedMimes)) {
            continue;
        }
        
        $text = '';
        $filePath = $file->getPathname();
        $filePathEscape = escapeshellarg($filePath);
        
        try {
            switch (mime_content_type($filePath)) {
                case 'application/pdf': {
                    $pdfInfo = array();
                    $key = '';
                    $val = '';
                    
                    // Считываем информацию о выбранном PDF файле
                    foreach (explode("\n", shell_exec(escapeshellcmd($pdfInfoPath . ' ' . $filePathEscape))) as $str) {
                        list($key, $val) = count(explode(':', $str)) == 2 ? explode(':', $str) : array('', '');
                        if (trim($key) && trim($val)) {
                            $pdfInfo[trim($key)] = trim($val);
                        }
                    }
                    
                    // Проверяем на ошибки
                    if (empty($pdfInfo) || (isset($pdfInfo['Error']) && $pdfInfo['Error'])) {
                        continue;
                    }
                    
                    // С помощью pdftotext считываем содержимое файла
                    $text = shell_exec(escapeshellcmd($pdfToTextPath . ' -nopgbrk ' . $filePathEscape . ' -'));
                    break;
                }
                case 'application/zip' : {
                    $file = Zend_Search_Lucene_Document_Docx::loadDocxFile($filePath);
                    // С помощью Zend_Search_Lucene_Document_Docx считываем содержимое файла
                    $text = $file->getFieldValue('body');
                    break;
                }
                
                case ('application/vnd.ms-office' || 'application/msword'): {
                    // С помощью catdoc считываем содержимое файла
                    $text = shell_exec(escapeshellcmd($catDocPath . ' ' . $filePathEscape));
                    break;
                }
            }

            if (empty($text)) {
                continue;
            }
            $text = strip_tags($text);
            $givenEncode = mb_detect_encoding($text);
            // Текст должен быть в кодировке UTF-8
            $text = $givenEncode ? iconv($givenEncode, 'UTF-8', $text) : mb_convert_encoding($text, 'UTF-8');
        
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            continue;
        }
        
        $xmlWriter->startElement('sphinx:document');
        // $folder->getBasename() - вернет название папки в которой хранятся наши файлы. 
        // Название папки является идентификатором пользователя
        $xmlWriter->writeAttribute('id', $folder->getBasename()); 
        $xmlWriter->startElement('content');

        $xmlWriter->writeCData($text);

        $xmlWriter->endElement(); // content
        $xmlWriter->endElement(); // field
    }
}
$xmlWriter->endElement();
$xml = $xmlWriter->outputMemory();

$tidy = tidy_repair_string($xml, array( 
    'output-xml' => true, 
    'input-xml'  => true 
), 'utf8');
echo $tidy;

