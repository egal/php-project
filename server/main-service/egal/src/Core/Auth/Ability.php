<?php

namespace Egal\Core\Auth;

enum Ability {
    case show;
    case showAny;
    case create;
    case createAny;
    case update;
    case updateAny;
    case delete;
    case deleteAny;
}
