<?php

namespace Matok\Bundle\CloudBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Matok\Bundle\CloudBundle\Form\Type\UploadFileType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function uploadAction(Request $request)
    {

        $form = $this->createForm(UploadFileType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->upload($data['file']);
        }

        return $this->render('CloudBundle:default:index.html.twig', [
            'form' => $form->createView(),
            'files' => $this->getUploadedFiles(5),
        ]);
    }


    private function upload(UploadedFile $file)
    {
        $targetDir = $this->getTargetDir();

        move_uploaded_file($file->getPathname(), $targetDir.DIRECTORY_SEPARATOR.$file->getClientOriginalName());
    }

    private function getUploadedFiles($limit)
    {
        $targetDir = $this->getTargetDir();
        $result = [];

        $finder = new Finder();
        $finder->files()->in($targetDir)->sort(function($a, $b) {return $b->getMTime() - $a->getMTime(); });

        foreach ($finder as $file) {
            $result[] = $file;

            if (count($result) == $limit) {
                break;
            }
        }

        return $result;
    }

    private function getTargetDir()
    {
        return $this->getParameter('kernel.project_dir').DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'files';
    }
}
