<?php

namespace SlotMachine;

const DISABLE_CURSOR = "\e[?25l";
const ENABLE_CURSOR = "\e[?25h";
const GO_TO_LINE_START = "\r";
const GO_ONE_LINE_UP = "\e[1A";
const GO_FOUR_LINES_UP = "\e[4A";
const CLEAR_LINE = "\e[2K";
