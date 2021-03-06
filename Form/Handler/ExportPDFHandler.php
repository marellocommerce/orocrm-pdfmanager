<?php

namespace Ibnab\Bundle\PmanagerBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Ibnab\Bundle\PmanagerBundle\Entity\Repository\PDFTemplateRepository;

class ExportPDFHandler
{
    /**
     * @var Request $request
     */
    protected $request;
    /**
     * @var PDFTemplateRepository $repository
     */
    protected $repository;

    /**
     * @param Request       $request
     */
    public function __construct(Request $request, PDFTemplateRepository $repository)
    {
        $this->request    = $request;
        $this->repository = $repository;
    }

    /**
     * Process form
     * @return bool True on successful processing, false otherwise
     */
    public function process()
    {
        if (in_array($this->request->getMethod(), array('POST', 'PUT'))) {
            $params = $this->request->get('ibnab_pmanager_exportpdf');
            if (isset($params['template']) && isset($params['entityClass']) && isset($params['entityId'])) {
                $resultTemplate = $this->repository->findOneBy(array('id' => $params['template']));
                if ($resultTemplate) {
                    if ($resultTemplate->getEntityName() == $params['entityClass']) {
                        return $resultTemplate;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
    
        return false;
    }
}
