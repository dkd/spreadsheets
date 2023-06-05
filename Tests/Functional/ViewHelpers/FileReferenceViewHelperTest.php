<?php

declare(strict_types=1);

namespace Hoogi91\Spreadsheets\Tests\Functional\ViewHelpers;

use TYPO3\CMS\Core\Resource\FileReference;

class FileReferenceViewHelperTest extends AbstractViewHelperTestCase
{
    public function testRenderWithoutFile(): void
    {
        self::assertNull($this->getView('<test:reader.fileReference uid=""/>')->render());
    }

    /**
     * @testWith [false, 0]
     *           [true, 123]
     */
    public function testRender(bool $expectFileReference, int $fileReferenceUid): void
    {
        $view = $this->getView('<test:reader.fileReference uid="{uid}"/>', ['uid' => $fileReferenceUid]);
        if ($expectFileReference === true) {
            $this->importCSVDataSet(__DIR__ . '/Fixtures/be_users.csv');
            $this->setUpBackendUser(1);
            $this->importCSVDataSet(__DIR__ . '/Fixtures/sys_file.csv');
            $this->importCSVDataSet(__DIR__ . '/Fixtures/sys_file_reference.csv'); // import dataset first, then render
            self::assertInstanceOf(FileReference::class, $view->render());
        } else {
            self::assertNull($view->render());
        }
    }
}
