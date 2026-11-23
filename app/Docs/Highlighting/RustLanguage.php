<?php

namespace App\Docs\Highlighting;

use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Tokens\TokenTypeEnum;

class RustLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'rust';
    }

    public function getAliases(): array
    {
        return ['rs'];
    }

    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            '/(?<match>\/\/[^\r\n]*|(?<block>\/\*(?:[^\/*]+|\/(?!\*)|\*(?!\/)|(?&block))*\*\/))/' => TokenTypeEnum::COMMENT,
            '/(?<match>\b(?:br|cr|r)(?<hashes>\#*)".*?"\k<hashes>)/s' => TokenTypeEnum::VALUE,
            '/(?<match>(?:b|c)?"(?:\\\\.|[^"\\\\])*"|b?\'(?:\\\\(?:u\{[0-9a-fA-F_]+\}|x[0-9a-fA-F]{2}|.)|[^\'\\\\\r\n])\')/s' => TokenTypeEnum::VALUE,
            '/(?<match>\#\!?\[[^\]]*\])/' => TokenTypeEnum::ATTRIBUTE,
            '/\b(?<match>as|async|await|break|const|continue|crate|dyn|else|enum|extern|false|fn|for|if|impl|in|let|loop|match|mod|move|mut|pub|ref|return|self|Self|static|struct|super|trait|true|type|union|unsafe|use|where|while|yield)\b/' => TokenTypeEnum::KEYWORD,
            '/\b(?<match>(?:[A-Z][A-Za-z0-9_]*|bool|char|str|[iu](?:8|16|32|64|128|size)|f(?:32|64)))\b/' => TokenTypeEnum::TYPE,
            '/\b(?<match>[a-zA-Z_]\w*!|[a-zA-Z_]\w*(?=\s*\())/' => TokenTypeEnum::PROPERTY,
        ];
    }
}
