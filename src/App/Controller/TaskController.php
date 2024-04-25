<?php

namespace App\Controller;

use Domain\Task\TaskManager;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="app_task")
     */
    public function index(): Response
    {
        return $this->render('task-1/task.html.twig');
    }

    /**
     * @Route("/task/proccess", name="process_task", methods={"POST"})
     * @throws Exception
     */
    public function process(Request $request, ValidatorInterface $validator, TaskManager $taskManager): Response
    {
        if($errors = $taskManager->validateRequest($request, $validator)) {
            return $this->render('task-1/task.html.twig', ['errors' => $errors, 'data' => $request->request->all()]);
        }

        $result = $taskManager->prepareResult($request);

        return $this->render('task-1/result.html.twig', compact('result'));
    }
}