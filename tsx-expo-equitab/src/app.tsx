import IconHeaderButton from "@/components/buttons/icon-header-button"
import { AppIcon } from "@/config/theme"
import ErrorScreen from "@/screens/error"
import FriendsScreen from "@/screens/friends"
import HomeScreen from "@/screens/home"
import SettingsScreen from "@/screens/settings"
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs"
import { NavigationContainer } from "@react-navigation/native"
import ErrorBoundary from "react-native-error-boundary"
import { SafeAreaProvider } from "react-native-safe-area-context"
import { HeaderButtons, Item } from "react-navigation-header-buttons"

const Tab = createBottomTabNavigator()

enum Routes {
	HOME = "Home",
	FRIENDS = "Friends",
	SETTINGS = "Settings",
}

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

function RootNavigator() {
	return (
		<Tab.Navigator initialRouteName={Routes.HOME}>
			<Tab.Screen
				name={Routes.HOME}
				component={HomeScreen}
				options={{
					tabBarIcon: props => <AppIcon name="home" {...props} />,
					headerShadowVisible: false,
					headerRight: () => (
						<HeaderButtons HeaderButtonComponent={IconHeaderButton}>
							<Item title="Create ledger" iconName="add" onPress={() => {}} />
						</HeaderButtons>
					),
				}}
			/>
			<Tab.Screen
				name={Routes.FRIENDS}
				component={FriendsScreen}
				options={{
					tabBarIcon: props => <AppIcon name="people" {...props} />,
					headerShadowVisible: false,
					headerRight: () => (
						<HeaderButtons HeaderButtonComponent={IconHeaderButton}>
							<Item title="Add friend" iconName="person-add" onPress={() => {}} />
						</HeaderButtons>
					),
				}}
			/>
			<Tab.Screen
				name={Routes.SETTINGS}
				component={SettingsScreen}
				options={{
					tabBarIcon: props => <AppIcon name="settings" {...props} />,
				}}
			/>
		</Tab.Navigator>
	)
}
