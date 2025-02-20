PROJECT_NAME = equitab
PACKAGE_NAME = com.zectan.equitab
DEVICE_ID = $(shell xcrun devicectl list devices | grep "iPhone" | grep -oE '[0-9A-F\-]{36}')
OUTPUT_PATH = $(shell find /Users/mac/Library/Developer/Xcode/DerivedData -name "$(PROJECT_NAME).app" | grep iphoneos | grep -v Index.noindex)

clean:
	xcodebuild -scheme $(PROJECT_NAME) clean
build:
	xcodebuild -scheme $(PROJECT_NAME) -destination "generic/platform=iOS" -configuration Debug build CODE_SIGN_IDENTITY="iPhone Developer"
install:
	xcrun devicectl device install app --device $(DEVICE_ID) $(OUTPUT_PATH)
launch:
	xcrun devicectl device process launch --device $(DEVICE_ID) $(PACKAGE_NAME)
run:
	@make build
	@make install
	@make launch