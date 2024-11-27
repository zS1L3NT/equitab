import RootNavigator from "@/navigator"
import ErrorScreen from "@/screens/error"
import { NavigationContainer } from "@react-navigation/native"
import ErrorBoundary from "react-native-error-boundary"
import { SafeAreaProvider } from "react-native-safe-area-context"

export default function App() {
	return (
		<ErrorBoundary FallbackComponent={ErrorScreen}>
			<NavigationContainer>
				<SafeAreaProvider>
					<RootNavigator />
				</SafeAreaProvider>
			</NavigationContainer>
		</ErrorBoundary>
	)
}
