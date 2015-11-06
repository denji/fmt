<?php
# Copyright (c) 2015, phpfmt and its authors
# All rights reserved.
#
# Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
#
# 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
#
# 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
#
# 3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
#
# THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

/**
 * @codeCoverageIgnore
 */
abstract class BaseCodeFormatter {
	protected $passes = [
		'StripSpaces' => false,

		'ReplaceBooleanAndOr' => false,
		'EliminateDuplicatedEmptyLines' => false,

		'RTrim' => false,
		'WordWrap' => false,

		'AlignPHPCode' => false,
		'ConvertOpenTagWithEcho' => false,
		'UpgradeToPreg' => false,
		'DocBlockToComment' => false,
		'LongArray' => false,

		'StripExtraCommaInArray' => false,
		'NoSpaceAfterPHPDocBlocks' => false,
		'RemoveUseLeadingSlash' => false,
		'ShortArray' => false,
		'MergeElseIf' => false,
		'AutoPreincrement' => false,
		'MildAutoPreincrement' => false,

		'CakePHPStyle' => false,

		'StripNewlineAfterClassOpen' => false,
		'StripNewlineAfterCurlyOpen' => false,

		'SortUseNamespace' => false,

		'TightConcat' => false,

		'PSR2IndentWithSpace' => false,

		'AllmanStyleBraces' => false,
		'NamespaceMergeWithOpenTag' => false,
		'MergeNamespaceWithOpenTag' => false,

		'LeftAlignComment' => false,

		'PSR2AlignObjOp' => false,
		'PSR2EmptyFunction' => false,
		'PSR2SingleEmptyLineAndStripClosingTag' => false,
		'PSR2ModifierVisibilityStaticOrder' => false,
		'PSR2CurlyOpenNextLine' => false,
		'PSR2LnAfterNamespace' => false,
		'PSR2KeywordsLowerCase' => false,

		'PSR1MethodNames' => false,
		'PSR1ClassNames' => false,

		'PSR1ClassConstants' => false,
		'PSR1BOMMark' => false,

		'EliminateDuplicatedEmptyLines' => false,
		'IndentTernaryConditions' => false,
		'ReindentEqual' => false,
		'Reindent' => false,
		'ReindentAndAlignObjOps' => false,
		'ReindentObjOps' => false,

		'AlignDoubleSlashComments' => false,
		'AlignTypehint' => false,
		'AlignGroupDoubleArrow' => false,
		'AlignDoubleArrow' => false,
		'AlignEquals' => false,

		'ReindentSwitchBlocks' => false,
		'ReindentColonBlocks' => false,

		'SplitCurlyCloseAndTokens' => false,
		'ResizeSpaces' => false,

		'StripSpaceWithinControlStructures' => false,

		'StripExtraCommaInList' => false,
		'YodaComparisons' => false,

		'MergeDoubleArrowAndArray' => false,
		'MergeCurlyCloseAndDoWhile' => false,
		'MergeParenCloseWithCurlyOpen' => false,
		'NormalizeLnAndLtrimLines' => false,
		'ExtraCommaInArray' => false,
		'SmartLnAfterCurlyOpen' => false,
		'AddMissingCurlyBraces' => false,
		'OnlyOrderUseClauses' => false,
		'OrderAndRemoveUseClauses' => false,
		'AutoImportPass' => false,
		'ConstructorPass' => false,
		'SettersAndGettersPass' => false,
		'NormalizeIsNotEquals' => false,
		'RemoveIncludeParentheses' => false,
		'TwoCommandsInSameLine' => false,

		'SpaceBetweenMethods' => false,
		'GeneratePHPDoc' => false,
		'ReturnNull' => false,
		'AddMissingParentheses' => false,
		'WrongConstructorName' => false,
		'JoinToImplode' => false,
		'EncapsulateNamespaces' => false,
		'PrettyPrintDocBlocks' => false,
		'StrictBehavior' => false,
		'StrictComparison' => false,
		'ReplaceIsNull' => false,
		'DoubleToSingleQuote' => false,
		'LeftWordWrap' => false,
		'ClassToSelf' => false,
		'ClassToStatic' => false,
		'PSR2MultilineFunctionParams' => false,
		'SpaceAroundControlStructures' => false,

		'OrderMethodAndVisibility' => false,
		'OrderMethod' => false,
		'OrganizeClass' => false,
		'AutoSemicolon' => false,
		'PSR1OpenTags' => false,
	];

	private $hasAfterExecutedPass = false;

	private $hasAfterFormat = false;

	private $hasBeforeFormat = false;

	private $hasBeforePass = false;

	private $shortcircuit = [
		'ReindentAndAlignObjOps' => 'ReindentObjOps',
		'ReindentObjOps' => 'ReindentAndAlignObjOps',
		'AllmanStyleBraces' => 'PSR2CurlyOpenNextLine',
		'AlignGroupDoubleArrow' => 'AlignDoubleArrow',
		'AlignDoubleArrow' => 'AlignGroupDoubleArrow',
		'OnlyOrderUseClauses' => 'OrderAndRemoveUseClauses',
		'OrderAndRemoveUseClauses' => 'OnlyOrderUseClauses',
	];

	public function __construct() {
		$this->passes['AddMissingCurlyBraces'] = new AddMissingCurlyBraces();
		$this->passes['EliminateDuplicatedEmptyLines'] = new EliminateDuplicatedEmptyLines();
		$this->passes['ExtraCommaInArray'] = new ExtraCommaInArray();
		$this->passes['LeftAlignComment'] = new LeftAlignComment();
		$this->passes['MergeCurlyCloseAndDoWhile'] = new MergeCurlyCloseAndDoWhile();
		$this->passes['MergeDoubleArrowAndArray'] = new MergeDoubleArrowAndArray();
		$this->passes['MergeParenCloseWithCurlyOpen'] = new MergeParenCloseWithCurlyOpen();
		$this->passes['NormalizeIsNotEquals'] = new NormalizeIsNotEquals();
		$this->passes['NormalizeLnAndLtrimLines'] = new NormalizeLnAndLtrimLines();
		$this->passes['OrderAndRemoveUseClauses'] = new OrderAndRemoveUseClauses();
		$this->passes['Reindent'] = new Reindent();
		$this->passes['ReindentEqual'] = new ReindentEqual();
		$this->passes['ReindentColonBlocks'] = new ReindentColonBlocks();
		$this->passes['ReindentObjOps'] = new ReindentObjOps();
		$this->passes['RemoveIncludeParentheses'] = new RemoveIncludeParentheses();
		$this->passes['ResizeSpaces'] = new ResizeSpaces();
		$this->passes['RTrim'] = new RTrim();
		$this->passes['SplitCurlyCloseAndTokens'] = new SplitCurlyCloseAndTokens();
		$this->passes['StripExtraCommaInList'] = new StripExtraCommaInList();
		$this->passes['TwoCommandsInSameLine'] = new TwoCommandsInSameLine();
		$this->hasAfterExecutedPass = method_exists($this, 'afterExecutedPass');
		$this->hasAfterFormat = method_exists($this, 'afterFormat');
		$this->hasBeforePass = method_exists($this, 'beforePass');
		$this->hasBeforeFormat = method_exists($this, 'beforeFormat');
	}

	public function disablePass($pass) {
		$this->passes[$pass] = null;
	}

	public function enablePass($pass) {
		$args = func_get_args();
		if (!isset($args[1])) {
			$args[1] = null;
		}

		if (!class_exists($pass)) {
			$passName = sprintf('ExternalPass%s', $pass);
			$passes = array_reverse($this->passes, true);
			$passes[$passName] = new ExternalPass($pass);
			$this->passes = array_reverse($passes, true);
			return;
		}

		$this->passes[$pass] = new $pass($args[1]);

		$scPass = &$this->shortcircuit[$pass];
		if (isset($scPass)) {
			$this->disablePass($scPass);
		}
	}

	public function formatCode($source = '') {
		$passes = array_map(
			function ($pass) {
				return clone $pass;
			},
			array_filter($this->passes)
		);
		$foundTokens = $this->getFoundTokens($source);
		$this->hasBeforeFormat && $this->beforeFormat($source);
		while (($pass = array_pop($passes))) {
			$this->hasBeforePass && $this->beforePass($source, $pass);
			if ($pass->candidate($source, $foundTokens)) {
				$source = $pass->format($source);
				$this->hasAfterExecutedPass && $this->afterExecutedPass($source, $pass);
			}
		}
		$this->hasAfterFormat && $this->afterFormat($source);
		return $source;
	}

	public function getPassesNames() {
		return array_keys(array_filter($this->passes));
	}

	protected function getToken($token) {
		$ret = [$token, $token];
		if (isset($token[1])) {
			$ret = $token;
		}
		return $ret;
	}

	private function getFoundTokens($source) {
		$foundTokens = [];
		$tkns = token_get_all($source);
		foreach ($tkns as $token) {
			list($id, $text) = $this->getToken($token);
			$foundTokens[$id] = $id;
		}
		return $foundTokens;
	}
}
