<?php

namespace Symfony5\View;

use Fdm\Presentation\Product\ImportProductsHtmlViewModel;
use Fdm\SharedUtils\Mail\MailSender;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class ImportProductsView
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var MailSender
     */
    private $mailSender;

    /**
     * @var ParameterBagInterface
     */
    private $params;

    private $translator;

    private $router;

    public function __construct(
        Environment $twig,
        MailSender $mailSender,
        ParameterBagInterface $params,
        TranslatorInterface $translator,
        RouterInterface $router
    )
    {
        $this->twig = $twig;
        $this->mailSender= $mailSender;
        $this->params = $params;
        $this->translator = $translator;
        $this->router = $router;
    }

    /**
     * @param $viewModel
     *
     * @return Response
     */
    public function generateView(ImportProductsHtmlViewModel $viewModel)
    {
        if(!is_null($viewModel->getCountProductsImported()))
        {
            $importParams = $this->params->get('import');
            $productImportParams = $importParams['product'];
            $subject = $productImportParams['title'];
            $recipients = explode(',', $productImportParams['email_to']);

            $body = $this->translator->trans('message_products_import',
                array(
                    'count' => $viewModel->getCountProductsImported(),
                    'name' => $viewModel->getSupplierImport()),
                'products'
            );

            $messageMail = $this->twig->render('shared/mail/mail_import.html.twig', ['subject' => $subject, 'body' => $body]);
            $this->mailSender->send($subject, $recipients, $messageMail);

            return new RedirectResponse($this->router->generate('homepage'));
        }

        return new Response(
            $this->twig->render('product/import.html.twig', array(
                    'suppliers' => $viewModel->suppliers
                )
            )
        );
    }

    public function sendMail()
    {


        $message = new Email();
        $message->subject($subject);
        $message->from(new Address($senderMail, $senderName));

        $message->sender(new Address($senderMail, $senderName));
        $message->addTo(new Address($recipient));
        $message->html($body, 'text/html');
        $this->mailer->send($message);
    }
}