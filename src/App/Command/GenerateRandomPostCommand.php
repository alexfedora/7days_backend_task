<?php

namespace App\Command;

use Domain\Post\PostManager;
use joshtronic\LoremIpsum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRandomPostCommand extends Command
{
    protected static $defaultName = 'app:generate-random-post';
    protected static $defaultDescription = 'Run app:generate-random-post {type} - type is optional argument. 
                                            Might be "summary" or "random". By default type is random';

    private PostManager $postManager;
    private LoremIpsum $loremIpsum;

    const SUMMARY_TYPE = 'summary';
    const RANDOM_TYPE = 'random';

    public function __construct(PostManager $postManager, LoremIpsum $loremIpsum, string $name = null)
    {
        parent::__construct($name);
        $this->postManager = $postManager;
        $this->loremIpsum = $loremIpsum;
    }

    protected function configure()
    {
        parent::configure();
        $this->addArgument('type', InputArgument::OPTIONAL, 'Is it summary or random post?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getArgument('type');
        if($type == self::SUMMARY_TYPE) {
            $title = 'Summary ' . date('Y-m-d');
            $content = $this->loremIpsum->paragraphs();
        } else {
            $title = $this->loremIpsum->words(mt_rand(4, 6));
            $content = $this->loremIpsum->paragraphs(2);
        }

        $this->postManager->addPost($title, $content);

        $message = "A " . ($type ?? self::RANDOM_TYPE) ." post has been generated.";
        $output->writeln($message);

        return Command::SUCCESS;
    }
}
