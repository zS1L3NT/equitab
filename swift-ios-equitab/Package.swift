// swift-tools-version:6.0

import PackageDescription

let projectName = "equitab"
let package = Package(
    name: projectName,
    platforms: [.iOS("18.0"), .macOS("15.0")],
    products: [
        .library(name: projectName, targets: [projectName])
    ],
    targets: [
        .target(
            name: projectName,
            path: projectName
        )
    ]
)
