<?php

namespace emeraldinspirations\library\applicationArchitecture;

interface ResponseModelInterface extends GenericAssocArrayInterface
{

    function withData(
        ResponseDataInterface $Data, string $Key
    ) : ResponseModelInterface;

}
